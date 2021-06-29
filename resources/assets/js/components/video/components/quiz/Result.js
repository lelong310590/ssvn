import React, {Component} from 'react';
import moment from "moment/moment";
import {Panel} from 'react-bootstrap';
import {Doughnut} from 'react-chartjs';
import _ from "lodash";
import axios from 'axios';
import * as api from './../../api';
import {Modal} from 'react-bootstrap';
import Rating from 'react-rating'

import ModalLeaderboard from './ModalLeaderboard';
import VideoContent from "../VideoContent";

class Result extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            result: [],
            showModal: false,
            showModalLeaderboard: false,
            initialRating: 0,
            rated: false,
            ratingComment: ''
        }
        this.toggleList = this.toggleList.bind(this)
        this.toggleExpand = this.toggleExpand.bind(this)
        this.nextLecture = this.nextLecture.bind(this)
        this.backToDashboard = this.backToDashboard.bind(this)
        this.reTest = this.reTest.bind(this)

        this.handleCloseModal = this.handleCloseModal.bind(this)
        this.handleRating = this.handleRating.bind(this)
        this.changeRating = this.changeRating.bind(this)
        this.changeRatingComment = this.changeRatingComment.bind(this);
    }

    toggleList() {
        this.props.toggleList()
    }

    toggleExpand(e, value) {
        let url = window.location.href;
        url = _.replace(_.replace(url, 'result/', 'review'), 'result', 'review') + '/' + value.id;
        window.location.href = url;
    }

    reTest() {
        let pageURL = window.location.href;
        let url = _.replace(pageURL, '/test/result', '/test/start');
        window.location.href = url;
    }

    changeRating(e) {
        this.setState({
            initialRating: e
        })
    }

    changeRatingComment(e) {
        let value = e.target.value;
        this.setState({
            ratingComment: value
        })
    }

    handleRating() {
        let {initialRating, ratingComment} = this.state;
        let {userId, lecture} = this.props;
        axios.post(api.POST_RATING, {
            initialRating, ratingComment, userId,
            courseid: lecture.course_id
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
            })
    }

    handleCloseModal() {
        this.setState({
            showModal: false
        })

        let path = window.location.pathname;
        path = path.split('/');
        path = path[1];
        window.location.href = api.BASE_URL + path;
    }

    openModalLeaderboard = () => {
        this.setState({
            showModalLeaderboard: true,
        });
    };

    closeModalLeaderboard = () => {
        this.setState({
            showModalLeaderboard: false,
        });
    };

    componentWillReceiveProps(props) {
        this.setState({
            userid: props.userId,
            lecture: props.lecture
        })

        axios.get(api.GET_RESULT, {
            params: {
                userid: props.userId,
                lecture: props.lecture.id
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                this.setState({
                    result: resp.data
                })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    nextLecture() {
        let {list, lecture} = this.props;
        let length = list.length;
        let index = _.findIndex(list, ['id', lecture.id]);
        if (length > index + 1) {
            let url = window.location.href;
            url = url.replace('/test/result', '');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            url = url.replace( new RegExp(str), '' ) + list[index+1].id;
            window.location.href = url;
        } else {
            axios.get(api.CHECK_IS_RATED, { // Kiem tra xem da rating chua
                params: {
                    author: this.props.userId,
                    course: this.props.lecture.course_id
                }
            })
            .then((resp) => {
                if (resp.status === 200) {
                    this.setState({
                        rated: resp.data.rated
                    })

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
    }

    backToDashboard() {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url + '?tab=2';
        window.location.href = destination;
    }

    render() {
        let {result} = this.state;

        let isExam = parseInt(this.props.isexam);
        let timeStart = parseInt(this.props.timestart);
        let timeEnd = parseInt(this.props.timeend);
        let timenow = Math.floor(Date.now() / 1000);

        let resultElem = result.map((value, index) => {
            let resultItemElem = value.map((v, i) => {

                let resultClass = (v.result === 'pass') ? 'result-pass' : 'result-failed';
                let total = v.wrong + v.correct + v.skip;
                return(
                    <div className="quiz-result-item" key={i}>
                        <Panel id="collapsible-panel-example-2" defaultExpanded={index === 0 && i === 0}>
                            <Panel.Heading>
                                <Panel.Title toggle>
                                    <div className="quiz-result-chart">
                                        <Doughnut data={[
                                            {
                                                value: v.skip,
                                                color:"#CCCCCC",
                                                highlight: "#CCCCCC",
                                                label: "Bỏ qua"
                                            },
                                            {
                                                value: v.correct,
                                                color: "#85edc2",
                                                highlight: "#4abd8e",
                                                label: "Đúng"
                                            },
                                            {
                                                value: v.wrong,
                                                color: "#ff7373",
                                                highlight: "#d04040",
                                                label: "Sai"
                                            }
                                        ]} options={{animationSteps: 100, animateRotate : true,}}/>
                                    </div>
                                    <div className={`quiz-result-status ${resultClass}`}>
                                    <span>
                                        {(v.result === 'pass') ? 'Đạt' : 'Trượt'}
                                    </span>
                                    </div>
                                    <div className="quiz-result-correct-percent">
                                        <span>Trả lời đúng: {v.percent_correct}% </span>
                                    </div>
                                    <div className="quiz-result-time-work">
                                        <span>{
                                            v.time ? (v.time < 60 ? `${v.time} giây` : `${parseInt(v.time/60)} phút`) : '0 phút'}</span>
                                    </div>
                                    <div className="quiz-result-date">
                                        <span>{moment(v.created_at).format('HH:mm D/M/Y')}</span>
                                    </div>
                                </Panel.Title>
                            </Panel.Heading>
                            <Panel.Collapse>
                                <Panel.Body>
                                    <div className="quiz-result-detail-container">
                                        <div className="quiz-result-detail-wrapper">
                                            <p className="quiz-result-detailt-attempt">
                                                Lần thi {value.length - i} :
                                                <span className={`${resultClass}`}>
                                                    {(v.result === 'pass') ? 'Đạt ' : 'Trượt '}
                                                    ( Điểm tối thiểu để qua: {v.score} %)
                                                </span>
                                            </p>
                                            <p className="quiz-result-detail-score">
                                                <span className="quiz-result-detail-big">{v.percent_correct}%</span>
                                                <span className="quiz-result-detail-small">
                                            Trả lời đúng ( {v.correct}/{total} )
                                       </span>
                                            </p>
                                            <p className="quiz-result-detail-time">
                                                {moment(v.created_at).format('HH:mm D/M/Y')}
                                            </p>
                                        </div>

                                        {timenow > timeEnd &&
                                            <div className="quiz-result-review">
                                                <button type="button"
                                                        className="btn btn-default"
                                                        onClick={(event) => this.toggleExpand(event, v)}
                                                >Xem đáp án</button>
                                            </div>
                                        }
                                    </div>
                                </Panel.Body>
                            </Panel.Collapse>
                        </Panel>
                    </div>
                )
            });

            return (
                <div className="quiz-result-detail-wrapper" key={index}>
                    <div className="quiz-result-version">
                        {/*<h4 className="quiz-result-version-title">Phiên bản {value[0].version}</h4>*/}
                        <div className="quiz-result-info">
                            <span>{value[0].skip + value[0].correct + value[0].wrong} Câu hỏi</span>
                            <span>{value[0].test_time} phút</span>
                            <span>Số điểm để qua bài: {value[0].score}%</span>
                        </div>
                    </div>
                    {resultItemElem}
                </div>
            )
        })

        return(
            <div>
                <header className="quiz-header quiz-result-header">
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
                <section className={'quiz-wrapper quiz-result-wrapper'}>
                    <div className={'quiz-result'}>
                        <div className="container">
                            <h1 className="quiz-result-title">
                                Trắc nghiệm
                            </h1>
                            <h4>
                                {result.reduce((accumulator, currentResult) => accumulator + currentResult.length, 0)} lần thi
                                <a className="pull-right btn btn-default"
                                   style={{
                                       fontSize: '17px',
                                       padding: '6px 29px',
                                       borderRadius: 0,
                                       color: '#007791',
                                   }}
                                   onClick={this.openModalLeaderboard}
                                >Bảng xếp hạng</a>
                            </h4>
                            {resultElem}
                        </div>
                    </div>
                    <footer className={'quiz-footer'}>
                        <div className="quiz-footer-toolbar">

                            {isExam !== 1 &&
                                <button
                                    className="quiz-footer-button quiz-footer-cancel"
                                    onClick={() => this.reTest()}
                                >
                                    Làm lại <i className="fas fa-chevron-right"></i>
                                </button>
                            }

                            <button
                                className="quiz-footer-button quiz-footer-start"
                                onClick={() => this.nextLecture()}
                            >
                                Tiếp tục <i className="fas fa-chevron-right"></i>
                            </button>
                            <button className="quiz-footer-button quiz-footer-setting">
                                <i className="fas fa-cog"></i>
                            </button>
                        </div>
                    </footer>
                </section>

                {
                    (this.state.lecture && this.state.lecture.id)
                    ? <ModalLeaderboard
                            isOpening={this.state.showModalLeaderboard}
                            onClose={this.closeModalLeaderboard}
                            lectureId={this.state.lecture.id}
                    />
                    : null
                }

                {this.state.showModalLeaderboard && <Modal show={this.state.showModal} onHide={this.handleCloseModal}>
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
                                initialRating={this.state.initialRating }
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
                </Modal>}
            </div>
        )
    }
}

export default Result;