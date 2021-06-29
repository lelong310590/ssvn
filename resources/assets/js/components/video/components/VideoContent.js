import React, {Component} from 'react';
import axios from 'axios';
import * as api from './../../curriculum/api';
import * as apis from './../api';
import Video from './Video';
import VideoHeader from './VideoHeader';
import Quiz from './quiz/Quiz';
import Question from "./quiz/Question";
import Aux from 'react-aux';

class VideoContent extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            lecture: {
                id: 1,
                type: ''
            },
            list: [],
            status : '',
            type : '',
        },


        this.toggleList = this.toggleList.bind(this);
        this.loadingComplete = this.loadingComplete.bind(this)
    }

    componentWillMount() {
        let courseId = this.props.courseid
        let lectureId = this.props.lectureid

        axios.get(api.GET_LECTURE_INFO_ROUTE, {
            params: {
                courseId, lectureId
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                this.setState({
                    lecture: resp.data.lecture,
                    list: resp.data.list
                })

                this.props.returnCurrentLecture(resp.data.lecture);
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    toggleList() {
        this.props.toggleList()
    }

    loadingComplete() {
        this.props.loadingComplete()
    }

    render() {
        let {lecture, list} = this.state;
        return(

            <div>
                {lecture.type === 'lecture' ? (
                    <div>
                        <Video
                            currentLecture={lecture}
                            showList={this.props.showList}
                            list={this.state.list}
                            userid={this.props.userid}
                            loadingComplete={this.loadingComplete}
                            courseid={this.props.courseid}
                        />

                        <VideoHeader
                            currentLecture={lecture}
                            list={list}
                            toggleList={this.toggleList}
                            showList={this.props.showList}
                        />
                    </div>
                ) : (
                    <div>
                        {this.state.status === 'start' ? (
                            <Question
                                loadingComplete={this.loadingComplete}
                            />
                        ) : (
                            <Aux>
                                <Quiz
                                    currentLecture={lecture}
                                    toggleList={this.toggleList}
                                    list={this.state.list}
                                    showList={this.props.showList}
                                    userid={this.props.userid}
                                    type={this.props.type}
                                    status={this.props.status}
                                    loadingComplete={this.loadingComplete}
                                    lectureid={this.props.lectureid}
                                    isexam={this.props.isexam}
                                    timestart={this.props.timestart}
                                    timeend={this.props.timeend}
                                    courseid={this.props.courseid}
                                />
                            </Aux>
                        )}
                    </div>
                )}
            </div>
        )
    }
}

export default VideoContent