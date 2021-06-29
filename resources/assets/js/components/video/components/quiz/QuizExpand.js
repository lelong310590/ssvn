import React, {Component} from 'react';
import axios from 'axios';
import _ from 'lodash';
import * as api from './../../api';
import RawHtml from 'react-raw-html';
import {Modal} from 'react-bootstrap';
import Rating from 'react-rating'

class QuizExpand extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            questions: {
                lecture: {
                    get_all_question: []
                }
            },
            answer: [],
            showModal: false,
            initialRating: 0,
            rated: false,
            ratingComment: ''
        }
        this.toggleList = this.toggleList.bind(this)
        this.backResult = this.backResult.bind(this)
        this.nextLecture = this.nextLecture.bind(this)
        this.reTest = this.reTest.bind(this)
        this.handleCloseModal = this.handleCloseModal.bind(this)
        this.handleRating = this.handleRating.bind(this)
        this.changeRating = this.changeRating.bind(this)
        this.changeRatingComment = this.changeRatingComment.bind(this)
    }

    toggleList() {
        this.props.toggleList()
    }

    componentWillMount() {
        let reviewID = window.location.pathname.split("/").pop();
        axios.get(api.RESULT_DETAIL, {
            params: {
                reviewID
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                let questions = resp.data;
                let answer = JSON.parse(resp.data.detail);
                this.setState({
                    questions,
                    answer: JSON.parse(answer)
                })
            }
        })
        .catch((err) => {
            console.log(err);
        })
    }

    reTest() {
        let pageURL = window.location.href;
        let urlArray = pageURL.split('/');
        pageURL = pageURL.replace(urlArray[9], '');
        let url = _.replace(pageURL, '/test/review', '/test/start');
        window.location.href = url;
    }

    changeRating(e) {
        this.setState({
            initialRating: e
        })
    }

    backResult()
    {
        let url = window.location.href;
        let str = url.substr(url.lastIndexOf('/') + 1) + '$';
        url = url.replace( new RegExp(str), '' );
        let reviewUrl = _.replace(url, 'review', 'result');
        window.location.href = reviewUrl;
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

    nextLecture() {
        let {list, lecture} = this.props;
        let length = list.length;
        let index = _.findIndex(list, ['id', lecture.id]);
        if (length > index + 1) {

            let path = window.location.pathname.split( '/' );
            let url = api.BASE_URL + path[1] + '/' + path[2] + '/' + path[3] + '/' + list[index+1].id;
            window.location.href = url;

        } else { //day la bai cuoi cung
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

    changeRatingComment(e) {
        let value = e.target.value;
        this.setState({
            ratingComment: value
        })
    }

    backToDashboard = () => {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url;
        window.location.href = destination;
    };

    render() {
        let {questions, answer, initialRating} = this.state;
        let questionsElem = questions.lecture.get_all_question.map((value, index) => {
            let answersElem = value.get_answer.map((v, i) => {
                let answerStatus = (v.answer === 'Y') ? 'correct-answer' : '';
                let check = (answer[index][i].answer === 'Y');
                let answerStatusCheck = check ? 'check-correct' : 'check-failed';
                let style = {};

                if(check && v.answer !== 'Y'){
                    style.backgroundColor = '#FAEBEB';
                }

                return (
                    <div className={`quiz-answer-item ${answerStatus}`} key={i} style={style}>
                        <div className={`answer-check radio`}>
                            <label>
                                <span className={`quiz-answer-radio ${answerStatusCheck}`}></span>
                                <RawHtml.div>{v.content}</RawHtml.div>
                                {v.answer === 'Y' &&
                                    <div className={`answer-result-correct`}>
                                        (Đáp án đúng)
                                    </div>
                                }
                                {check && v.answer !== 'Y' &&
                                    <div className={`answer-result-correct`} style={{ color: 'red' }}>
                                        (Đáp án sai)
                                    </div>
                                }
                            </label>
                        </div>
                    </div>
                )
            });

            let ans = value.get_answer;
            let idxOfQuestion = _.findIndex(ans, ['answer', 'Y']);
            let userAnswer = answer[index];
            let idxOfUserAnswer = _.findIndex(userAnswer, ['answer', 'Y']);
            let questionStatusText = '';
            return (
                <div key={index} className={'quiz-review-question-item'}>
                    <div className="quiz-review-question-header">
                        <span>Câu hỏi {index + 1}: </span>
                        {idxOfQuestion === idxOfUserAnswer ? (
                            <span className={`quiz-review-question-right`}>Đúng</span>
                        ) : (
                            <span className={`quiz-review-question-wrong`}>Sai</span>
                        )}
                        {/*<span className="quiz-review-question-status">Trả lời sai</span>*/}
                    </div>
                    <div className="quiz-review-question-content">
                        <RawHtml.div>{value.content}</RawHtml.div>
                    </div>
                    <div className="quiz-review-question-list-answers quiz-answer-wrapper">
                        {answersElem}
                    </div>
                    {!_.isNull(value.reason) &&
                        <div className="quiz-review-reason">
                            <p className="quiz-review-reason-title">Giải thích :</p>
                            <RawHtml.div>{value.reason}</RawHtml.div>
                        </div>
                    }
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
                            <div className="quiz-review-wrapper">
                                <div
                                    className="quiz-review-back btn btn-default"
                                    onClick={() => this.backResult()}
                                >Quay lại</div>
                            </div>
                            <div className="quiz-review-wrapper-inner">
                                {questionsElem}
                            </div>
                        </div>
                    </div>
                    <footer className={'quiz-footer'}>
                        <div className="quiz-footer-toolbar">
                            <button
                                className="quiz-footer-button quiz-footer-cancel"
                                onClick={() => this.reTest()}
                            >
                                Làm lại <i className="fas fa-chevron-right"></i>
                            </button>
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
        )
    }
}

export default QuizExpand;