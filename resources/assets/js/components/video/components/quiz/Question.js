import React, {Component} from 'react';
import axios from 'axios';
import _ from 'lodash';
import RawHtml from "react-raw-html";
import moment from "moment/moment";
import {Modal, Button} from 'react-bootstrap';
import ListQuestions from "./ListQuestions";
import * as api from './../../api';

class Question extends Component
{
    state = {
        lecture: {},
        questions: [],
        start: 0,
        onFinalQuestion: false,
        answers: [],
        time: 0,
        showModal: false,
        showListQuestion: false,
        tableSheet: [],
        multiAnswer: [],
        listQuestion: [],
        dosomething: false,
        answeredQuestions: [],
        isModalTimeoutShowing: false,
        isTestSubmitting: false,
    };

    handleCloseModal = () => {
        this.setState({
            showModal: false
        })
    };

    handleShowModal = () => {
        this.setState({
            showModal: true
        })
    };

    toggleList = () => {
        this.props.toggleList()
    };

    closeList = () => {
        this.setState({
            showListQuestion: false
        })
    };

    showModalTimeout = () => {
        this.setState({
            isModalTimeoutShowing: true,
        });
    };

    hideModalTimeout = () => {
        this.setState({
            isModalTimeoutShowing: false,
        });
    };

    componentWillReceiveProps(props) {
        this.setState({
            lecture: props.lecture,
            questions: props.questions,
            time: props.lecture.time*60
        });

        let {answers, tableSheet} = this.state;


        props.questions.map((value, index) => {
            if (props.questions.length > answers.length) {
                answers.push(value.get_answer);
                tableSheet.push({id: value.id});
            }
        })


        answers.map((value, index) => {
            _.map(value, (a, idx) => {
                a.answer = 'N';
            })
        });


        this.setState({answers})
        localStorage.setItem('answers', JSON.stringify(answers));
    }

    componentDidMount() {
        this.startTest();
        setTimeout(() => {
            this.loadingComplete();
        }, 1000);
    }

    loadingComplete = () => {
        this.props.loadingComplete()
    };

    requestFullscreen = () => {
        this.launchIntoFullscreen(document.documentElement);
        this.exitFullscreen();
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
    }

    exitFullscreen = () => {
        if(document.exitFullscreen) {
            document.exitFullscreen();
        } else if(document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if(document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    };

    listQuestion = () => {
        let {showListQuestion} = this.state;

        this.setState({
            showListQuestion: !showListQuestion
        })
    };

    changeAnswer = (q, index, type = '', value = null) => {
        let {answers, choosenAnswer, start, multiAnswer} = this.state;
        this.setState({
            dosomething: true
        });
        let {questions} = this.props;

        let answerInQuestion = answers[q];

        if (type !== 'multi') {
            answerInQuestion.map((value, i) => {
                value.answer = 'N'
            })
        }

        if (type === 'multi') {
            let currentValue = answerInQuestion[index].answer;

            answerInQuestion[index].answer = (currentValue === 'N') ? 'Y' : 'N';
            if (currentValue === 'N') {
                multiAnswer.push(value);
                this.setState({multiAnswer})
            } else {
                let idx = multiAnswer.indexOf(value);
                if (idx >= 0) {
                    multiAnswer.splice(idx, 1);
                    this.setState({multiAnswer})
                }
                //console.log(multiAnswer);
            }

        } else {
            answerInQuestion[index].answer = 'Y';
        }


        this.setState({answers});
        this.addQuestionToAnsweredList(questions[start].id);

        let axiosData = {
            question: questions[start].id,
            answers: (type !== 'multi') ? answerInQuestion[index].id : multiAnswer,
        }

        axios.post(api.CHECK_ANSWER, axiosData)
        .then((resp) => {
            if (resp.status === 200) {
                let {tableSheet} = this.state;
                let index =_.findIndex(tableSheet, ['id', resp.data.id]);
                tableSheet[index] = resp.data;
                this.setState({
                    tableSheet
                })
            }

        })
        .catch((err) => {
            console.log(err)
        })

        localStorage.setItem('answers', JSON.stringify(answers));

    }

    changeQuestionInList = (current) => {
        this.setState({
            start: current
        });
    };

    addQuestionToAnsweredList = (questionId) => {
        let { answeredQuestions } = this.state;
        if(!answeredQuestions.includes(questionId)){
            this.setState({
                answeredQuestions: [
                    ...answeredQuestions,
                    questionId,
                ]
            });
        }
    };

    nextQuestion = () => {
        let {start, questions, answeredQuestions} = this.state;
        if (questions.length > start + 1) {
            this.setState({
                start: start + 1,
                dosomething: false
            });
            this.addQuestionToAnsweredList(questions[start + 1].id);
        } else {
            this.setState({
                onFinalQuestion: true
            })
        }
    }

    prevQuestion = () => {
        let {start, questions} = this.state;
        if (start > 0) {
            this.setState({
                start: start - 1,
                onFinalQuestion: false,
            })
        }
    }

    startTest = () => {
        setInterval(this.timer, 1000);
    }

    timer = () => {
        // setState method is used to update the state
        let {time} = this.state;
        this.setState({ time: time -1 }, () => {
            if(this.state.time === 0){
                this.showModalTimeout();
            }
        });
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

            }
        })
        .catch((err) => {
            console.log(err)
        })
    };

    submitTest = () => {
        this.setState({
            isSubmittingTest: true,
        });
        let url = window.location.href;
        let {userId} = this.props;
        let {tableSheet, lecture} = this.state;
        let answers = localStorage.getItem('answers');
        let wrong = 0;
        let correct = 0;
        let skip = 0;
        let length = this.props.questions.length;

        tableSheet.map((v, i) => {
            if (v.correct === true) {
                correct++;
            }

            if (v.wrong === true) {
                wrong++;
            }
        });

        skip = length - wrong - correct;

        let status = true;
        this.completeLecture(lecture.id, lecture.course_id, userId, status); //Cap nhat trang thai da hoc xong

        answers = JSON.parse(answers);

        _.map(answers, (ans, index) => {
            _.map(ans, (a, idx) => {
                a.content = null;
                delete a.created_at;
                delete a.updated_at;
                delete a.reason;
            })

        });


        axios.post(api.SUBMIT_LECTURE, {
            answers: JSON.stringify(answers),
            userId,
            lectureId: this.props.lecture.id,
            questions: null,
            skip,
            wrong,
            correct,
            score: this.props.lecture.score,
            version: this.props.lecture.version,
            test_time: this.props.lecture.time,
            time: this.props.lecture.time*60 - this.state.time,
            courseid: this.props.courseid,
            isexam: this.props.isexam
        })
        .then((resp) => {
            //console.log(resp);
            if (resp.status === 200) {
                url = url.replace('start', 'result');
                window.location.href = url;
            }
        })
        .catch((err) => {
            console.log(err)
        })
    };

    backToDashboard = () => {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url + '?tab=2';
        window.location.href = destination;
    }

    render() {
        let {lecture, questions, start, answers, isModalTimeoutShowing, isSubmittingTest} = this.state;
        let questionNo = start + 1;
        let answersList = (!_.isEmpty(questions[start])) ? questions[start].get_answer : [];

        let answersElem = answersList.map((value, index) => {
            return(
                <div className={'quiz-answer-item'} key={index}>
                    <div className={`answer-check ${questions[start].type === 'multi' ? 'checkbox' : 'radio'}`}>
                        <label>
                            <input
                                type={questions[start].type === 'multi' ? 'checkbox' : 'radio'}
                                className="custom-control-input"
                                name="answer"
                                checked={answers[start][index].answer === 'Y'}
                                value={value.id}
                                onChange={() => this.changeAnswer(start, index, questions[start].type, value.id)}
                            />
                            <span className="cr"><i className="cr-icon fas fa-circle"></i></span>
                            <RawHtml.div>{value.content}</RawHtml.div>
                        </label>
                    </div>
                </div>
            )
        })

        let classStyle = (this.state.showListQuestion === true) ? 'quiz-open-right': '';

        return(
            <div style={{height: '100%'}}>
                <div className={`quiz-fullscreen quiz-question ${classStyle}`}>
                    <header className={`quiz-header ${classStyle}`}>
                    <button
                        className="quiz-header-button"
                        onClick={() => this.toggleList()}
                    >
                        <i className="fas fa-list-ul"></i>
                    </button>

                    <div className="practice-test-time">
                        <div className="question-count">
                            {start + 1} / {questions.length}
                        </div>
                        <div className="practice-process">
                            <div className="practive-process-running"
                                 style={{width: ((start + 1) / questions.length * 100) + '%'}}
                            >
                            </div>
                        </div>
                        <div className="practice-time">
                            <i className="far fa-clock"></i>
                            {moment.utc(this.state.time*1000).format('HH:mm:ss')}
                        </div>
                    </div>

                    <button
                        className={'quiz-header-back-to-dashboard'}
                        onClick={() => this.backToDashboard()}
                    >
                        Về trang Khóa đào tạo
                    </button>
                </header>
                    <section className={'quiz-wrapper'}>
                        <div className={'quiz-wrapper-inner'}>
                            <div className={'quiz-title quiz-question-title'}>Câu hỏi {questionNo}</div>
                            <div className="quiz-description">
                                <RawHtml.div>{!_.isEmpty(questions[start]) ? questions[start].content : ''}</RawHtml.div>
                            </div>
                            <div className="quiz-answer-wrapper">
                                {answersElem}
                            </div>
                        </div>
                    </section>
                    <footer className={`quiz-footer ${classStyle}`}>
                        <div className="quiz-footer-seeall">
                            <button
                                className="quiz-footer-button quiz-footer-cancel"
                                onClick={() => this.listQuestion()}
                            >
                                Xem danh sách câu hỏi
                            </button>
                        </div>
                        <div className="quiz-footer-toolbar">
                            <button
                                className="quiz-footer-button quiz-footer-cancel"
                                onClick={() => this.prevQuestion()}
                            >
                                Quay lại
                            </button>
                            {this.state.onFinalQuestion === true ? (
                                <button
                                    className="quiz-footer-button quiz-footer-start"
                                    onClick={() => this.handleShowModal()}
                                >
                                    Nộp bài <i className="fas fa-chevron-right"></i>
                                </button>
                            ) : (
                                <button
                                    className={`quiz-footer-button ${this.state.dosomething ? 'quiz-footer-start' : 'quiz-footer-skip'}`}
                                    onClick={() => this.nextQuestion()}
                                >
                                    {this.state.dosomething ? 'Câu tiếp' : 'Bỏ qua'} <i className="fas fa-chevron-right"></i>
                                </button>
                            )}
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
                            <Modal.Title>Bạn có chắc chắn nộp bài </Modal.Title>
                        </Modal.Header>
                        <Modal.Body>
                            <p>
                                Khi nộp bài, bạn sẽ không thể thay đổi được kết quả, các câu chưa trả lời sẽ được coi là trả lời sai
                            </p>
                        </Modal.Body>
                        <Modal.Footer>
                            <button
                                type="reset"
                                className="btn btn-tertiary"
                                onClick={() => this.handleCloseModal()}
                            >Quay lại</button>
                            <Button
                                type="submit"
                                className="btn btn-secondary"
                                onClick={() => this.submitTest()}
                                disabled={isSubmittingTest}
                            >Nộp bài</Button>
                        </Modal.Footer>
                    </Modal>
                </div>
                <ListQuestions
                    questions={this.props.questions}
                    currentQuestion={this.state.start}
                    showListQuestion={this.state.showListQuestion}
                    closeList={this.closeList}
                    changeQuestionInList={this.changeQuestionInList}
                    curriculumid={this.props.curriculumid}
                    lectureid={this.props.lectureid}
                    answeredQuestions={this.state.answeredQuestions}
                />
                <Modal show={isModalTimeoutShowing} onHide={this.hideModalTimeout} backdrop="static">
                    <Modal.Body>Đã hết thời gian làm bài</Modal.Body>
                    <Modal.Footer>
                        <Button onClick={this.submitTest} disabled={isSubmittingTest}>Xem kết quả</Button>
                    </Modal.Footer>
                </Modal>
            </div>
        )
    }
}

export default Question;