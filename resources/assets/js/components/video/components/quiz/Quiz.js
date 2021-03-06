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
                                V??? trang Kh??a ????o t???o
                            </button>
                        </header>
                        <section className={'quiz-wrapper quiz-lesson'}>
                            <div className={'quiz-wrapper-inner'}>
                                <div className={'quiz-title'}>{lecture.name}</div>
                                <div className={'quiz-meta'}>
                                    <span className={'quiz-total-question'}>S??? c??u h???i: {lecture.total_question}</span>
                                    <span className={'quiz-total-time'}>Th???i gian l??m b??i: {lecture.time} ph??t</span>
                                    <span className={'quiz-total-score'}>S??? ??i???m y??u c???u: {lecture.score}</span>
                                </div>
                                <div className="quiz-description">
                                    <RawHtml.div>{lecture.description}</RawHtml.div>
                                </div>
                                <div className="quiz-introduction">
                                    <p>H?????ng d???n:</p>
                                    <ul>
                                        <li>B???n c?? th??? t???m d???ng ki???m tra b???t k??? l??c n??o v?? ti???p t???c sau.</li>
                                        <li>B???n c?? th??? l??m l???i b??i ki???m tra bao nhi??u l???n t??y th??ch.</li>
                                        <li>Thanh ti???n tr??nh ??? ?????u m??n h??nh s??? hi???n th??? ti???n tr??nh c???a b???n c??ng nh?? th???i
                                            gian c??n l???i trong b??i ki???m tra. N???u b???n h???t th???i gian, ?????ng lo l???ng; b???n v???n c??
                                            th??? ho??n th??nh b??i ki???m tra.
                                        </li>
                                        <li>B???n c?? th??? b??? qua m???t c??u h???i ????? quay l???i v??o cu???i b??i ki???m tra.</li>
                                        <li>N???u b???n mu???n k???t th??c ki???m tra v?? xem k???t qu??? c???a b???n ngay l???p t???c, h??y nh???n n??t
                                            d???ng.
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
                                    B??? qua
                                </button>
                                <button
                                    className="quiz-footer-button quiz-footer-start"
                                    onClick={() => this.startQuiz(lecture)}
                                >
                                    B???t ?????u <i className="fas fa-chevron-right"></i>
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
                                <Modal.Title>B???n c?? mu???n ????nh gi?? Kh??a ????o t???o n??y</Modal.Title>
                            </Modal.Header>
                            <Modal.Body>
                                <p>
                                    C?? v??? nh?? b???n ???? ho??n th??nh Kh??a ????o t???o n??y. B???n h??y ????? l???i ????nh gi?? ph???n h???i v??? Kh??a ????o t???o ?
                                </p>
                                <div className="rating-wrapper">
                                    <Rating
                                        emptySymbol="far fa-star fa-2x"
                                        fullSymbol="fas fa-star fa-2x"
                                        initialRating={initialRating}
                                        onChange={this.changeRating}
                                    />
                                    <div className="rating-comment">
                                        <p>Nh???n x??t c???a b???n v??? Kh??a ????o t???o n??y</p>
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
                                >Kh??ng mu???n</button>
                                <button
                                    type="submit"
                                    className="btn btn-secondary"
                                    onClick={() => this.handleRating()}
                                >G???i ????nh gi??</button>
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
                        <Modal.Title>B??o c??o n???i dung</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <form>
                            <FormGroup>
                                <ControlLabel>N???i dung</ControlLabel>
                                <FormControl componentClass="textarea" />
                            </FormGroup>
                        </form>
                    </Modal.Body>
                    <Modal.Footer>
                        <Button onClick={this.hideModalReport}>????ng</Button>
                        <Button bsStyle="primary">G???i b??o c??o</Button>
                    </Modal.Footer>
                </Modal>
            </div>
        )
    }
}

export default Quiz;