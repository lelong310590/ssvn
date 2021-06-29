import React, {Component} from 'react'
import ReactPlayer from 'react-player'
import videojs from 'video.js';
import * as api from "../api";
import axios from "axios/index";
import _ from 'lodash';
import ToggleButton from 'react-toggle-button'

import VideoPlayer from './VideoPlayer';

class Video extends Component {
    state = {
        url: '',
        playing: true,
        volume: 0.8,
        muted: false,
        played: 0,
        loaded: 0,
        duration: 0,
        playbackRate: 1.0,
        loop: false,
        lists: [],
        complete: false,
        nextLecture: '',
        lectureUrl: '',
        userid: this.props.userid,
        autoNext: true,
        autoNextTime: 5,
        isShowingFinishedScreen: false,
    };

    getUrl = () => {
        let lectureId = this.props.currentLecture.id;

        axios.get(api.GET_VIDEO, {
            params: {
                lecture: lectureId
            }
        })
            .then((resp) => {
                let url = api.VIDEO_URL + resp.data.url;
                this.setState({
                    url: url
                })
            })
            .catch((err) => {
                console.log(err)
            })
    }

    getNextLecture = () => {
        axios.get(api.GET_SLUG, {
            params: {
                course: this.props.currentLecture.id
            }
        })
            .then((res) => {
                if (res.status === 200) {
                    let slug = api.BASE_URL + '/' + res.data.get_course.slug + '/hoc/bai-hoc';
                    this.setState({
                        lectureUrl: slug
                    });
                    this.loadingComplete();
                }
            })
            .catch((err) => {
                console.log(err)
            })
    }

    loadingComplete = () => {
        this.props.loadingComplete()
    }

    componentWillMount() {
        this.setState({
            lists: this.props.list
        })

        axios.all([this.getUrl(), this.getNextLecture()])
            .then(
                axios.spread(function (acct, perms) {

                })
            )

    }

    completeLecture = (courseid, section, userid, status) => {
        axios.post(api.CHANGE_PROCESS, {
            section,
            courseid,
            userid,
            status
        })
            .then((resp) => {
                if (resp.status === 200) {
                    this.setState({
                        complete: true,
                    })
                }
            })
            .catch((err) => {
                console.log(err)
            })
    }

    onProgress = (state) => {

        const {url, playing, volume, muted, loop, played, loaded, duration, playbackRate, lists, lectureUrl, autoNext} = this.state;
        let current = this.props.currentLecture;
        let index = _.findIndex(lists, ['id', current.id]);

        let status = true;
        let lectureid = this.props.currentLecture.id;
        let courseid = this.props.courseid;
        let userid = this.state.userid;

        if ((state.playedSeconds / duration) * 100 > 90) {
            this.completeLecture(lectureid, courseid, userid, status)
        }

        if (state.playedSeconds === duration && (lists.length != (index + 1))) {
            //this.completeLecture(lectureid, courseid, userid, status)
            axios.get(api.GET_AUTOPLAY, {
                params: {
                    id: this.props.userid
                }
            })
                .then((res) => {
                    if (res.status === 200) {
                        let autoNext = (res.data.meta_value === 'true') ? true : false;
                        let {autoNextTime} = this.state;

                        if (autoNext === true) {
                            setInterval(this.timer, 1000);
                        }

                        this.setState({
                            autoNext
                        })
                    }
                })
                .catch((err) => {
                    console.log(err);
                })

            let next = lectureUrl;
            this.setState({
                complete: true,
                nextLecture: lists[index + 1],
                lectureUrl: next + '/' + lists[index + 1].id
            })
        }
        // We only want to update time slider if we are not currently seeking
        if (!this.state.seeking) {
            this.setState(state)
        }
    }

    stay = () => {
        this.setState({
            complete: false,
            autoNextTime: 5
        })
        clearInterval(this.timer())
    }

    onDuration = (duration) => {
        this.setState({duration})
    }

    next = () => {
        let url = this.state.lectureUrl;
        window.location.href = url;
    }

    timer = () => {
        // setState method is used to update the state
        if (this.state.autoNext === true) {
            let {autoNextTime} = this.state;
            if (autoNextTime > 0) {
                this.setState({autoNextTime: autoNextTime - 1});
            }
            if (this.state.autoNextTime === 0) {
                let url = this.state.lectureUrl;
                window.location.href = url;
            }
        } else {
            this.setState({autoNextTime: 5});
        }
    }

    changeToggle = () => {
        let {autoNext, autoNextTime} = this.state;
        this.setState({
            autoNext: !autoNext
        })

        axios.post(api.SET_AUTOPLAY, {
            autoplay: !autoNext,
            userid: this.props.userid
        })
            .then((resp) => {
                // console.log(resp)
            })
            .catch((err) => {
                console.log(err)
            })

        if (autoNext === true && autoNextTime >= 0) {
            setInterval(this.timer, 1000);
        } else {
            clearInterval(this.timer());
            this.setState({
                autoNextTime: 5
            })
        }
    };

    updatePlayedTime = (playedTime) => {
        this.setState({
            played: playedTime,
        }, this.updateProgress);
    };

    updateDuration = (duration) => {
        this.setState({duration});
    };

    updateProgress = () => {
        const {complete, played, duration, lists, lectureUrl} = this.state;
        const {courseid, userid, currentLecture} = this.props;
        const currentLectureIndex = _.findIndex(lists, {id: currentLecture.id});

        if (!complete && played && duration && (played / duration) * 100 > 90) {
            this.completeLecture(currentLecture.id, courseid, userid, true);
        }

        if (played && duration && played === duration && ((currentLectureIndex + 1) <= lists.length)) {
            axios.get(api.GET_AUTOPLAY, {
                params: {
                    id: this.props.userid
                }
            })
                .then((res) => {
                    if (res.status === 200) {
                        let autoNext = (res.data.meta_value === 'true') ? true : false;
                        let {autoNextTime} = this.state;

                        if (autoNext === true) {
                            setInterval(this.timer, 1000);
                        }

                        this.setState({
                            autoNext
                        })
                    }
                })
                .catch((err) => {
                    console.log(err);
                })

            let next = lectureUrl;
            this.setState({
                complete: true,
                isShowingFinishedScreen: true,
                nextLecture: lists[currentLectureIndex + 1],
                lectureUrl: next + '/' + lists[currentLectureIndex + 1].id
            });
        }
    }

    render() {
        let {url, playing, volume, muted, loop, played, loaded, duration, playbackRate, isShowingFinishedScreen} = this.state;
        let classStyle = this.props.showList ? 'player-left-open' : '';
        const videoJsOptions = {
            autoplay: true,
            controls: true,
            sources: [{
                src: url,
                type: 'video/mp4',
            }],
            playbackRates: [
                0.5,
                0.75,
                1,
                1.25,
                1.5,
                2,
            ],
            eventListeners: {
                timeupdate: (event) => {
                    const player = event.target.player;
                    if (player && player.currentTime) {
                        this.updatePlayedTime(player.currentTime());
                    }
                },
                durationchange: (event) => {
                    const player = event.target.player;
                    if (player && player.duration) {
                        this.updateDuration(player.duration())
                    }
                },
                play: (event) => {
                    const player = event.target.player;
                }
            }
        }
        return (
            <div>
                {isShowingFinishedScreen === true &&
                <div className={'complete-wrapper'}>
                    <div className="complete-inner">
                        <div className="complete-content">
                            <p className="complete-label">Bài học đang xem</p>
                            <h2 className="complete-course-label">
                                {this.props.currentLecture.index + '. '}
                                {this.props.currentLecture.name}
                            </h2>
                        </div>
                        <div className="complete-content-next">
                            <p className="complete-label">Bài học tiếp theo</p>
                            <h2 className="complete-course-label">
                                {this.state.nextLecture.index + '. '}
                                {this.state.nextLecture.name}
                            </h2>
                        </div>
                        <div className="complete-toolbar">
                            <button
                                className={'btn btn-primary go-to-next-button'}
                                onClick={this.next}
                            >Tiếp tục
                            </button>
                            <button
                                className={'btn btn-default stay-here-button'}
                                onClick={this.stay}
                            >Ở lại
                            </button>
                        </div>
                        <div className="complete-toggle">
                            <ToggleButton
                                value={this.state.autoNext}
                                onToggle={() => this.changeToggle()}
                            />
                            {this.state.autoNext === true ? (
                                <label>Tự động chuyển bài trong {this.state.autoNextTime} ...</label>
                            ) : (
                                <label>Đã tắt tự động chuyển bài</label>
                            )}
                        </div>
                    </div>
                </div>
                }
                <div className={`player-fullscreen ${classStyle}`}>
                    {url && url.length && <VideoPlayer {...videoJsOptions} />}
                    {/*<div data-vjs-player>*/}
                    {/*<video ref={ node => this.videoNode = node } className="video-js"></video>*/}
                    {/*<ReactPlayer*/}
                    {/*className='video-js'*/}
                    {/*url={url}*/}
                    {/*playing*/}
                    {/*controls*/}
                    {/*onDuration={this.onDuration}*/}
                    {/*onProgress={this.onProgress}*/}
                    {/*/>*/}
                    {/*</div>*/}
                </div>
                )}
            </div>
        )
    }
}

export default Video
