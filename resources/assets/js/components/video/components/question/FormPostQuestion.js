import React, {Component} from 'react';
import _ from "lodash";
import * as api from "../../../curriculum/api";
import {POST_QUESTION} from "../../api";
import TinyMCE from 'react-tinymce';
import axios from "axios/index";

class FormPostQuestion extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            questionTitle: '',
            questionContent: '',
            validated: false
        }
        this.addQuestionTitle = this.addQuestionTitle.bind(this)
        this.addQuestionContent = this.addQuestionContent.bind(this)
        this.toggleFormQuest = this.toggleFormQuest.bind(this)
        this.onPostQuestion = this.onPostQuestion.bind(this)
        this.addedQuestion = this.addedQuestion.bind(this)
    }

    addQuestionTitle(e) {
        let title = e.target.value;
        this.setState({questionTitle: title})
        let {questionContent, questionTitle} = this.state;
        if (questionContent !== '' && questionTitle !== '' ) {
            this.setState({validated: true})
        }
    }

    addQuestionContent(e) {
        let content = e.target.getContent();
        this.setState({questionContent: content})
        let {questionContent, questionTitle} = this.state;
        if (questionContent !== '' && questionTitle !== '' ) {
            this.setState({validated: true})
        }
    }

    toggleFormQuest(status) {
        this.props.toggleFormQuest(status)
    }

    addedQuestion(value) {
        this.props.addedQuestion(value);
    }

    onPostQuestion() {
        return e => {
            e.preventDefault();
            let {questionTitle, questionContent, validated} = this.state;
            if (validated === true) {
                axios.post(POST_QUESTION, {
                    title: questionTitle,
                    content: questionContent,
                    lectureid: this.props.lectureid,
                    courseid: this.props.courseid,
                    userid: this.props.userid
                })
                .then((resp) => {
                    console.log(resp)
                    if (resp.status === 200) {
                        this.toggleFormQuest(false)
                        this.addedQuestion(resp.data)
                    }

                })
                .catch((err) => {
                    console.log(err)
                })
            }
        }
    }

    render() {
        return(
            <form className={'lecture-question-create'} onSubmit={this.onPostQuestion()}>
                <p>Bạn gặp sự cố kỹ thuật? Nhóm hỗ trợ của chúng tôi có thể trợ giúp.</p>
                <div className="lecture-question-create-content">
                    <input
                        maxLength="600"
                        placeholder="Tiêu đề"
                        className="form-control"
                        type="text"
                        value={this.state.questionTitle}
                        onChange={(event) => this.addQuestionTitle(event)}
                    />

                    <TinyMCE
                        content={this.state.questionContent}
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
                        onChange={this.addQuestionContent}
                    />
                </div>
                <div className="lecture-question-action">
                    <button
                        className={'cancel-question'}
                        type={'button'}
                        onClick={() => this.toggleFormQuest(false)}
                    >Đóng</button>

                    <button
                        className={'create-question'}
                        type={'submit'}
                        disabled={(this.state.validated === false) ? true : false}
                    >Tạo câu hỏi</button>
                </div>
            </form>
        )
    }
}

export default FormPostQuestion;