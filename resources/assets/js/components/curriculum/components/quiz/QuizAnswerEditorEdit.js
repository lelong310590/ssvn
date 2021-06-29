import React, {Component} from 'react';
import _ from 'lodash';
import TinyMCE from 'react-tinymce';
import * as api from './../../api';
import axios from 'axios';

class QuizAnswerEditorEdit extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            answer: '',
            reason: ''
        }
        this.addNewAnswer = this.addNewAnswer.bind(this);
        this.addAnswer = this.addAnswer.bind(this);
        this.addReason = this.addReason.bind(this)
    }

    componentWillMount() {
        let {answer} = this.props;
        this.setState({
            answer: (_.isNull(answer.content)) ? '' : answer.content,
            reason: (_.isNull(answer.reason)) ? '' : answer.reason
        })
    }

    addNewAnswer(index) {
        this.props.addNewAnswer(index)
    }

    addAnswer(event) {
        let {index} = this.props;
        let answer = event.target.getContent();
        this.setState({answer})
        this.props.addAnswer(answer, index)
    }

    addReason(event) {
        let {index} = this.props;
        let reason = event.target.getContent();
        this.setState({reason})
        this.props.addReason(reason, index)
    }

    render() {
        let {index, answer} = this.props;
        return (
            <div className="answer-content-editor">
                <TinyMCE
                    content={(_.isNull(answer.content)) ? this.state.answer : answer.content}
                    config={{
                        plugins: 'autolink link image lists print preview fullscreen',
                        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image | fullscreen',
                        paste_data_images: true,
                        file_picker_callback: function(callback, value, meta) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');
                            input.click();
                            input.onchange = function() {
                                var file = this.files[0];
                                let formData = new FormData()
                                formData.append('file', file)

                                const config = {
                                    headers: {'Content-Type': 'multipart/form-data'},
                                }

                                axios.post(api.UPLOAD_IMAGE, formData, config)
                                    .then((response) => {
                                        var reader = new FileReader();
                                        reader.onload = function(e) {
                                            callback(response.data, {
                                                alt: ''
                                            });
                                        };
                                        reader.readAsDataURL(file);
                                    })
                                    .catch((error) => {
                                        console.log(err);
                                    })
                            }
                        },
                        language_url: api.BASE_URL + 'frontend/js/vi_VN.js'
                    }}
                    onChange={this.addAnswer}
                    onClick={() => this.addNewAnswer(index)}
                />
            </div>
        )
    }
}

export default QuizAnswerEditorEdit;