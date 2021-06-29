import React, {Component} from 'react'
import * as api from "../../../curriculum/api";
import TinyMCE from 'react-tinymce';
import axios from "axios/index";
import {EDIT_ANSWER, EDIT_QUESTION} from "../../api";

class EditAnswer extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            content: '',
            validated: false
        }

        this.addAnswerContent = this.addAnswerContent.bind(this)
        this.gotoEditAnswer = this.gotoEditAnswer.bind(this)
    }

    componentWillMount() {
        let {title, content} = this.props;
        this.setState({
            title, content
        })
    }

    addAnswerContent(e) {
        let value = e.target.getContent();
        this.setState({content: value})
        let {content} = this.state;
        if (content !== '' ) {
            this.setState({validated: true})
        }
    }

    onPostEditAnswer() {
        return e => {
            e.preventDefault();
            let {content, validated} = this.state;
            let {id} = this.props;
            if (validated === true) {
                axios.post(EDIT_ANSWER, {
                    id,
                    content
                })
                .then((resp) => {
                    if (resp.status === 200) {
                        this.props.editedAnswer(resp.data)
                        this.gotoEditAnswer(false, this.props.value)
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        }
    }

    gotoEditAnswer(status, value) {
        this.props.gotoEditAnswer(status, value);
    }

    render() {
        return(
            <form className={'lecture-question-create lecture-question-onedit'} onSubmit={this.onPostEditAnswer()}>
                <div className="lecture-question-create-content">
                    <TinyMCE
                        content={this.state.content}
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
                        onChange={this.addAnswerContent}
                    />
                </div>
                <div className="lecture-question-action">
                    <button
                        className={'cancel-question'}
                        type={'button'}
                        onClick={() => this.gotoEditAnswer(false, this.props.value)}
                    >Đóng</button>

                    <button
                        className={'create-question'}
                        type={'submit'}
                        disabled={(this.state.validated === false) ? true : false}
                    >Sửa câu trả lời</button>
                </div>
            </form>
        )
    }
}

export default EditAnswer;