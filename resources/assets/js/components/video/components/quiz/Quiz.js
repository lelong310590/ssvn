import React, {Component} from 'react';
import axios from 'axios';
import * as api from './../../../curriculum/api'
import * as apis from './../../api'
import RawHtml from "react-raw-html";
import Question from "./Question";
import moment from 'moment';
import Result from "./Result";
import QuizExpand from "./QuizExpand";
import _ from "lodash";
import { Modal, FormControl, FormGroup, ControlLabel, Button } from 'react-bootstrap';
import Rating from 'react-rating'
import VideoContent from "../VideoContent";

class Quiz extends Component
{
    state = {
        lecture: {
            name: '',
            total_question: 0,
            time: 0,
            score: 0,
            description: ''
        },
        url: window.location.pathname,
        userid: this.props.userid,
        type: '',
        status: '',
        questions: [],
        haveResult: false,
        lectureid: this.props.lectureid,
        showModal: false,
        initialRating: 0,
        rated: false,
        ratingComment: '',
        isModalReportOpening: false,
    };

    loadingComplete = () => {
        this.props.loadingComplete()
    };

    handleCloseModal = () => {
        this.setState({
            showModal: false
        });

        let path = window.location.pathname;
        path = path.split('/');
        path = path[1];
        window.location.href = api.BASE_URL + path;
    };

    changeRating = (e) => {
        this.setState({
            initialRating: e
        })
    };

    handleRating = () => {
        let {initialRating, ratingComment} = this.state;
        let {userid, currentLecture} = this.props;
        axios.post(apis.POST_RATING, {
            initialRating, ratingComment, userId: userid,
            courseid: currentLecture.course_id
        })
        .then((resp) => {
            if (resp.status === 200) {
                let path = window.location.pathname;
                path = path.split('/');
                path = path[1];
                window.location.href = api.BASE_URL + path;
            }
        })
        .catch((err) => {
            console.log(err)
        });
    };

    changeRatingComment = (e) => {
        let value = e.target.value;
        this.setState({
            ratingComment: value
        })
    }

    componentWillReceiveProps(nextProps) {
        this.setState({
            lecture: nextProps.currentLecture,
            type: nextProps.type,
            status: nextProps.status,
        });
        let {type, status, userid} = this.state;
        if ((type === 'test' || type === 'quiz') && status === 'start') {
            axios.post(api.GET_ALL_QUESTION_AND_ANSWER, {
                lectureid: nextProps.currentLecture,
                userid
            })
            .then((resp) => {
                if (resp.status === 200) {
                    this.setState({
                        questions: resp.data.questions,
                        haveResult: resp.data.haveResult
                    })
                }

                // if (resp.data.haveResult === true) {
                //     let url = window.location.href;
                //     let str = url.substr(url.lastIndexOf('/') + 1) + '$';
                //     url = url.replace( new RegExp(str), '' ) + 'result';
                //     window.location.href = url;
                // }

            })
            .catch((err) => {
                console.log(err)
            })
        }
    }

    componentDidMount() {
        setTimeout(() => {
            this.loadingComplete();
        }, 3000);
    }

    toggleList = () => {
        this.props.toggleList()
    };

    startQuiz = (lecture) => {
        let url = window.location.href;
        window.location.href = url + '/' + lecture.type + '/start'
    };

    skipQuiz = (lecture) => {
        let {list} = this.props;
        let length = list.length;
        let index = _.findIndex(list, ['id', lecture.id]);
        if (length > index + 1) {
            let url = window.location.href;
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            url = url.replace( new RegExp(str), '' ) + list[index+1].id;
            window.location.href = url;
        } else {
            axios.get(apis.CHECK_IS_RATED, { // Kiem tra xem da rating chua
                params: {
                    author: this.props.userid,
                    course: this.props.currentLecture.course_id
                }
            })
            .then((resp) => {
                console.log(resp);
                if (resp.status === 200) {
                    this.setState({
                        rated: resp.data.rated
                    });

                    if (!resp.data.rated) {
                        this.setState({
                            showModal: true
                        })
                    } else {
                        let path = window.location.pathname;
                        path = path.split('/');
                        path = path[1];
                        window.location.href = api.BASE_URL + path;
                    }
                }
            })
            .catch((err) => {
                console.log(err)
            })
        }
    };

    backToDashboard = () => {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url + '?tab=2';
        window.location.href = destination;
    };

    showModalReport = () => {
        this.setState({
            isModalReportOpening: true,
        })
    };

    hideModalReport = () => {
        this.setState({
            isModalReportOpening: false,
        })
    };

    requestFullscreen = () => {
        this.launchIntoFullscreen(document.documentElement);
    };

    launchIntoFullscreen = (element) => {
        if(element.requestFullscreen) {
            element.requestFullscreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    };

    exitFullscreen = () => {
        if(document.exitFullscreen) {
            document.exitFullscreen();
        } else if(document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if(document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    };

    render() {
        let {lecture, type, status, questions, time, initialRating, isModalReportOpening} = this.state;
        let classStyle = this.props.showList ? 'player-left-open' : '';

        return(
            <div className={`player-fullscreen ${classStyle} `}>
                {(type === 'test' || type === 'quiz') && status === 'start' &&
                    <Question
                        questions={questions}
                        lecture={lecture}
                        toggleList={this.toggleList}
                        userId={this.props.userid}
                        loadingComplete={this.loadingComplete}
                        lectureid={this.state.lectureid}
                        courseid={this.props.courseid}
                        isexam={this.props.isexam}
                    />
                }

                {(type === '' && status === '') &&
                    <div className={'quiz-wrapper'}>
                        <header className="quiz-header">
                            <button
                                className="quiz-header-button"
                                onClick={() => this.toggleList()}
                            >
                                <i className="fas fa-list-ul"></i>
                            </button>
                            <button
                                className={'quiz-header-back-to-dashboard'}
                                onClick={() => this.backToDashboard()}
                            >
                                Về trang Khóa đào tạo
                            </button>
                        </header>
                        <section className={'quiz-wrapper quiz-lesson'}>
                            <div className={'quiz-wrapper-inner'}>
                                <div className={'quiz-title'}>{lecture.name}</div>
                                <div className={'quiz-meta'}>
                                    <span className={'quiz-total-question'}>Số câu hỏi: {lecture.total_question}</span>
                                    <span className={'quiz-total-time'}>Thời gian làm bài: {lecture.time} phút</span>
                                    <span className={'quiz-total-score'}>Số điểm yêu cầu: {lecture.score}</span>
                                </div>
                                <div className="quiz-description">
                                    <RawHtml.div>{lecture.description}</RawHtml.div>
                                </div>
                                <div className="quiz-introduction">
                                    <p>Hướng dẫn:</p>
                                    <ul>
                                        <li>Bạn có thể tạm dừng kiểm tra bất kỳ lúc nào và tiếp tục sau.</li>
                                        <li>Bạn có thể làm lại bài kiểm tra bao nhiêu lần tùy thích.</li>
                                        <li>Thanh tiến trình ở đầu màn hình sẽ hiển thị tiến trình của bạn cũng như thời
                                            gian còn lại trong bài kiểm tra. Nếu bạn hết thời gian, đừng lo lắng; bạn vẫn có
                                            thể hoàn thành bài kiểm tra.
                                        </li>
                                        <li>Bạn có thể bỏ qua một câu hỏi để quay lại vào cuối bài kiểm tra.</li>
                                        <li>Nếu bạn muốn kết thúc kiểm tra và xem kết quả của bạn ngay lập tức, hãy nhấn nút
                                            dừng.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </section>
                        <footer className={'quiz-footer'}>
                            <div className="quiz-footer-toolbar">
                                <button
                                    className="quiz-footer-button quiz-footer-cancel"
                                    onClick={() => this.skipQuiz(lecture)}
                                >
                                    Bỏ qua
                                </button>
                                <button
                                    className="quiz-footer-button quiz-footer-start"
                                    onClick={() => this.startQuiz(lecture)}
                                >
                                    Bắt đầu <i className="fas fa-chevron-right"></i>
                                </button>
                                <button
                                    className="quiz-footer-button quiz-footer-setting"
                                    onClick={this.showModalReport}
                                >
                                    <i className="fas fa-cog"></i>
                                </button>
                                <button
                                    className="quiz-footer-button quiz-footer-setting"
                                    onClick={() => this.requestFullscreen()}
                                >
                                    <i className="fas fa-arrows-alt"></i>
                                </button>
                            </div>
                        </footer>

                        <Modal show={this.state.showModal} onHide={this.handleCloseModal}>
                            <Modal.Header>
                                <Modal.Title>Bạn có muốn đánh giá Khóa đào tạo này</Modal.Title>
                            </Modal.Header>
                            <Modal.Body>
                                <p>
                                    Có vẻ như bạn đã hoàn thành Khóa đào tạo này. Bạn hãy để lại đánh giá phản hồi về Khóa đào tạo ?
                                </p>
                                <div className="rating-wrapper">
                                    <Rating
                                        emptySymbol="far fa-star fa-2x"
                                        fullSymbol="fas fa-star fa-2x"
                                        initialRating={initialRating}
                                        onChange={this.changeRating}
                                    />
                                    <div className="rating-comment">
                                        <p>Nhận xét của bạn về Khóa đào tạo này</p>
                                        <textarea
                                            cols="30"
                                            rows="5"
                                            value={this.state.ratingComment || ''}
                                            onChange={(e) => this.changeRatingComment(e)}
                                            className={`form-control`}
                                        >
                                </textarea>
                                    </div>
                                </div>
                            </Modal.Body>
                            <Modal.Footer>
                                <button
                                    type="reset"
                                    className="btn btn-tertiary"
                                    onClick={() => this.handleCloseModal()}
                                >Không muốn</button>
                                <button
                                    type="submit"
                                    className="btn btn-secondary"
                                    onClick={() => this.handleRating()}
                                >Gửi đánh giá</button>
                            </Modal.Footer>
                        </Modal>
                    </div>
                }

                {(type === 'test' || type === 'quiz') && status === 'result' &&
                    <Result
                        toggleList={this.toggleList}
                        lecture={lecture}
                        userId={this.props.userid}
                        list={this.props.list}
                        isexam={this.props.isexam}
                        timestart={this.props.timestart}
                        timeend={this.props.timeend}
                    />
                }

                {(type === 'test' || type === 'quiz') && status === 'review' &&
                    <QuizExpand
                        toggleList={this.toggleList}
                        userId={this.props.userid}
                        list={this.props.list}
                        lecture={lecture}
                    />
                }

                <Modal show={isModalReportOpening} onHide={this.hideModalReport} backdrop="static">
                    <Modal.Header>
                        <Modal.Title>Báo cáo nội dung</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <form>
                            <FormGroup>
                                <ControlLabel>Nội dung</ControlLabel>
                                <FormControl componentClass="textarea" />
                            </FormGroup>
                        </form>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button onClick={this.hideModalReport}>Đóng</Button>
                        <Button bsStyle="primary">Gửi báo cáo</Button>
                    </Modal.Footer>
                </Modal>
            </div>
        )
    }
}

export default Quiz;