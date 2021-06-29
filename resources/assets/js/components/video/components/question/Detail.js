import React, {Component} from 'react';
import RawHtml from 'react-raw-html';
import _ from "lodash";
import {BASE_URL, LIST_ANSWER, POST_ANSWER, POST_QUESTION, DELETE_QUESTION} from "../../api";
import * as api from "../../../curriculum/api";
import TinyMCE from 'react-tinymce';
import axios from "axios/index";
import moment from 'moment'
import {ButtonToolbar, Dropdown, MenuItem, Modal} from 'react-bootstrap'
import EditQuestion from "./EditQuestion";
import EditAnswer from "./EditAnswer";

class Detail extends Component
{
    constructor(props) {
        super(props)
        this.state = {
            question: {
                id: 1,
                title: '',
                content: '',
                owner: {
                    thumbnail: '',
                    first_name: '',
                    last_name: ''
                },
                onEdit: false
            },
            answerContent: '',
            answers: [],
            showModal: false,
            deleteId: '',
            deleteType: ''
        }

        this.addAnswer = this.addAnswer.bind(this)
        this.backToList = this.backToList.bind(this)
        this.postAnswer = this.postAnswer.bind(this)
        this.gotoEditAnswer = this.gotoEditAnswer.bind(this)
        this.gotoEditQuestion = this.gotoEditQuestion.bind(this)
        this.updatedQuestion = this.updatedQuestion.bind(this)
        this.editedAnswer = this.editedAnswer.bind(this)
        this.gotoDetailQA = this.gotoDetailQA.bind(this)
        this.handleCloseModal = this.handleCloseModal.bind(this)
        this.handleDeleteItem = this.handleDeleteItem.bind(this)
        this.deleteQuestion = this.deleteQuestion.bind(this)
    }

    componentWillMount() {
        let {question} = this.props;
        this.setState({question})

        axios.get(LIST_ANSWER, {
            params: {
                question: question.id,
                author: this.props.userid,
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                this.setState({
                    answers: resp.data
                })
            }
        })
        .catch((err) => {
            console.log(err);
        })
    }

    backToList() {
        this.props.backToList()
    }

    addAnswer(e) {
        let content = e.target.getContent();
        this.setState({
            answerContent: content
        })
    }

    handleCloseModal() {
        this.setState({
            showModal: false
        });
    }

    postAnswer() {
        return e => {
            e.preventDefault();
            let {answerContent, question, answers} = this.state;
            if (answerContent !== '') {
                axios.post(POST_ANSWER, {
                    answerContent,
                    question: question.id,
                    author: this.props.userid
                })
                .then((resp) => {
                    if (resp.status === 200) {
                        answers.push(resp.data);
                        this.setState({
                            answers,
                            answerContent: ''
                        })
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        }
    }

    gotoEditQuestion(value) {
        let {question} = this.state;
        question.onEdit = value;
        this.setState({
            question
        })
    }

    updatedQuestion(question) {
        this.setState({
            question
        })
    }

    gotoEditAnswer(status, value) {
        let {answers} = this.state;
        let idx = _.findIndex(answers, ['id', value.id]);
        answers[idx].onEdit = status;
        this.setState({answers})
    }

    editedAnswer(value) {
        let {answers} = this.state;
        let idx = _.findIndex(answers, ['id', value.id]);
        answers[idx] = value;
        this.setState({answers})
    }

    gotoDetailQA() {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url + '?tab=3';
        window.open(destination);
    }

    handleDeleteItem(id, type) {
        axios.get(DELETE_QUESTION, {
            params: {
                id,
                qatype: type
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                if (type === 'answer') {
                    let {answers} = this.state;
                    let answerIdx = _.findIndex(answers, ['id', id]);
                    _.pullAt(answers, answerIdx)
                    this.setState(answers)
                }

                if (type === 'question') {
                    this.props.handleDeleteQuestion(id);
                    this.backToList()
                }

                this.setState({showModal: false})
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    deleteQuestion(id, type) {
        this.setState({
            showModal: true,
            deleteId: id,
            deleteType: type
        });
    }

    render() {
        let {question, answers} = this.state;
        let {userid} = this.props;
        let thumbnail = question.owner.thumbnail;
        let firstName = !_.isNull(question.owner.first_name) ? question.owner.first_name.substring(0,1) : '';
        let lastName = !_.isNull(question.owner.last_name) ? question.owner.last_name.substring(0,1) : '';
        let name = firstName + lastName;

        let answerList = answers.map((value, index) => {
            let thumbnailAnswer = value.owner.thumbnail;
            let firstNameAnswer = !_.isNull(value.owner.first_name) ? value.owner.first_name.substring(0,1) : '';
            let lastNameAnswer = !_.isNull(value.owner.last_name) ? value.owner.last_name.substring(0,1) : '';
            let nameAnswer = firstNameAnswer + lastNameAnswer;
            let answerContent = !_.isNull(value.content) ? value.content.replace(/<[^>]+>/g, '') : '';
            return (
                <div className={`answer-list-item-reply`} key={index}>
                    <div className="question-list-item-avatar">
                        {_.isEmpty(thumbnailAnswer) ? (
                            <div className={`question-list-item-avatar-text`}>
                                <div className="question-list-item-avatar-text-detail">
                                    {nameAnswer}
                                </div>
                            </div>
                        ) : (
                            <img src={BASE_URL + thumbnailAnswer} className={`img-responsive question-list-item-avatar`} width={40} height={40} />
                        )}
                    </div>
                    <div className="question-list-item-content">
                        <div className="question-list-item-title-name">
                            {value.owner.first_name} - <span>{moment(value.updated_at).fromNow()}</span>
                        </div>
                        <div className="question-list-item-content-detail">
                            {value.onEdit === false &&
                                <RawHtml.div>{answerContent}</RawHtml.div>
                            }

                            {value.onEdit === true &&
                                <EditAnswer
                                    content={value.content}
                                    id={value.id}
                                    value={value}
                                    gotoEditAnswer={this.gotoEditAnswer}
                                    editedAnswer={this.editedAnswer}
                                />
                            }
                        </div>
                    </div>
                    <div className="question-list-item-detail-action">
                        <ButtonToolbar>
                            <Dropdown id="dropdown-custom-1">
                                <Dropdown.Toggle>
                                    <i className="fas fa-ellipsis-v"></i>
                                </Dropdown.Toggle>
                                <Dropdown.Menu>
                                    {parseInt(userid) === value.author &&
                                    <MenuItem eventKey="2"
                                              onClick={() => this.gotoEditAnswer(true, value)}
                                    >Sửa</MenuItem>
                                    }

                                    {parseInt(userid) === value.author &&
                                        <MenuItem eventKey="3"
                                            onClick={() => this.deleteQuestion(value.id, 'answer')}
                                        >
                                            Xóa</MenuItem>
                                    }
                                </Dropdown.Menu>
                            </Dropdown>
                        </ButtonToolbar>
                    </div>
                </div>
            )
        })

        return(
            <div className={`question-list-item-wrapper question-list-item-wrapper-detail`}>
                <div className="question-list-item-detail-back"
                    onClick={() => this.backToList(false)}
                >
                    <i className="fas fa-long-arrow-alt-left"></i>
                </div>
                <div className={`question-list-item`}>

                    <div className="question-list-item-avatar">
                        {_.isEmpty(thumbnail) ? (
                            <div className={`question-list-item-avatar-text`}>
                                <div className="question-list-item-avatar-text-detail">
                                    {name}
                                </div>
                            </div>
                        ) : (
                            <img src={BASE_URL + thumbnail} className={`img-responsive question-list-item-avatar`} width={40} height={40} />
                        )}
                    </div>
                    <div className="question-list-item-content">
                        {question.onEdit === false &&
                            <div className="question-list-item-title">
                                {question.title}
                            </div>
                        }
                        <div className="question-list-item-title-name">
                            {question.owner.first_name} - <span>{moment(question.updated_at).fromNow()}</span>
                        </div>
                        {question.onEdit === false &&
                            <div className="question-list-item-content-detail">
                                <RawHtml.div>{question.content}</RawHtml.div>
                            </div>
                        }
                        {question.onEdit === true &&
                            <EditQuestion
                                questionTitle={question.title}
                                questionContent={question.content}
                                gotoEditQuestion={this.gotoEditQuestion}
                                id={question.id}
                                updatedQuestion={this.updatedQuestion}
                            />
                        }
                    </div>
                    <div className="question-list-item-detail-action">
                        <ButtonToolbar>
                            <Dropdown id="dropdown-custom-1">
                                <Dropdown.Toggle>
                                    <i className="fas fa-ellipsis-v"></i>
                                </Dropdown.Toggle>
                                <Dropdown.Menu>
                                    <MenuItem eventKey="1"
                                              onClick={() => this.gotoDetailQA()}
                                    >Chi tiết thảo luận</MenuItem>
                                    {parseInt(userid) === question.author &&
                                        <MenuItem eventKey="2"
                                                  onClick={() => this.gotoEditQuestion(true)}
                                        >Sửa</MenuItem>
                                    }

                                    {parseInt(userid) === question.author &&
                                        <MenuItem eventKey="3"
                                                  onClick={() => this.deleteQuestion(question.id, 'question')}
                                        >
                                            Xóa</MenuItem>
                                    }
                                </Dropdown.Menu>
                            </Dropdown>
                        </ButtonToolbar>
                    </div>
                </div>
                <div className="answer-list-item">
                    <div className="answer-list-editor">
                        {answerList}
                        <form className={'answer-list-editor-form'} onSubmit={this.postAnswer()}>
                            <label>Gửi câu trả lời của bạn</label>
                            <TinyMCE
                                content={this.state.answerContent || ''}
                                config={{
                                    plugins: 'image',
                                    toolbar: 'bold italic | image',
                                    paste_data_images: true,
                                    file_picker_callback: function(callback, value, meta) {
                                        var input = document.createElement('input');
                                        input.setAttribute('type', 'file');
                                        input.setAttribute('accept', 'image/*');
                                        input.click();
                                        input.onchange = function() {
                                            var file = this.files[0];
                                            var reader = new FileReader();
                                            reader.onload = function(e) {
                                                callback(e.target.result, {
                                                    alt: ''
                                                });
                                            };
                                            reader.readAsDataURL(file);
                                        }
                                    },
                                    language_url: api.BASE_URL + 'frontend/js/vi_VN.js'
                                }}
                                onChange={this.addAnswer}
                            />
                            <button className={`btn btn-danger`} type={`submit`}>Trả lời</button>
                        </form>
                    </div>
                </div>

                <Modal show={this.state.showModal} onHide={this.handleCloseModal}>
                    <Modal.Header>
                        {this.state.deleteType === 'question' &&
                            <Modal.Title>Bạn có chắc chắn xóa câu hỏi</Modal.Title>
                        }

                        {this.state.deleteType === 'answer' &&
                            <Modal.Title>Bạn có chắc chắn xóa câu trả lời</Modal.Title>
                        }
                    </Modal.Header>
                    <Modal.Body>
                        {this.state.deleteType === 'question' &&
                        <p>
                            Bạn sắp xóa một câu hỏi. Mọi câu trả lời cho câu hỏi này cũng sẽ bị xóa cùng. Bạn có chắc chắn muốn tiếp tục không?
                        </p>
                        }

                        {this.state.deleteType === 'answer' &&
                            <p>
                                Bạn sắp xóa một câu trả lời. Bạn có chắc chắn muốn tiếp tục không?
                            </p>
                        }

                    </Modal.Body>
                    <Modal.Footer>
                        <button
                            type="reset"
                            className="btn btn-tertiary"
                            onClick={() => this.handleCloseModal()}
                        >Đóng</button>
                        <button
                            type="submit"
                            className="btn btn-secondary"
                            onClick={() => this.handleDeleteItem(this.state.deleteId, this.state.deleteType)}
                        >Xóa</button>
                    </Modal.Footer>
                </Modal>
            </div>
        )
    }
}

export default Detail;