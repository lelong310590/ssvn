import React, {Component} from 'react';
import * as api from "../../../curriculum/api";
import TinyMCE from 'react-tinymce';
import axios from "axios/index";
import {EDIT_QUESTION, POST_QUESTION} from "../../api";

class EditQuestion extends Component
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
        this.gotoEditQuestion = this.gotoEditQuestion.bind(this)
    }

    componentWillMount() {
        let {questionTitle, questionContent} = this.props;
        this.setState({
            questionTitle, questionContent
        })
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

    gotoEditQuestion(status) {
        this.props.gotoEditQuestion(status)
    }

    onPostQuestion() {
        return e => {
            e.preventDefault();
            let {questionTitle, questionContent, validated} = this.state;
            let {id} = this.props;
            if (validated === true) {
                axios.post(EDIT_QUESTION, {
                    title: questionTitle,
                    content: questionContent,
                    id
                })
                .then((resp) => {
                    if (resp.status === 200) {
                        this.props.updatedQuestion(resp.data)
                        this.gotoEditQuestion(false)
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
            <form className={'lecture-question-create lecture-question-onedit'} onSubmit={this.onPostQuestion()}>
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
                            file_browser_callback : function(field_name, url, type, win) {
                                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                                var cmsURL = api.BASE_URL + 'cdn-filemanager?field_name=' + field_name;
                                if (type == 'image') {
                                    cmsURL = cmsURL + "&type=Images";
                                } else {
                                    cmsURL = cmsURL + "&type=Files";
                                }
                                tinyMCE.activeEditor.windowManager.open({
                                    file : cmsURL,
                                    title : 'Filemanager',
                                    width : x * 0.8,
                                    height : y * 0.8,
                                    resizable : "yes",
                                    close_previous : "no"
                                });
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
                        onClick={() => this.gotoEditQuestion(false)}
                    >Đóng</button>

                    <button
                        className={'create-question'}
                        type={'submit'}
                        disabled={(this.state.validated === false) ? true : false}
                    >Sửa câu hỏi</button>
                </div>
            </form>
        )
    }
}

export default EditQuestion;