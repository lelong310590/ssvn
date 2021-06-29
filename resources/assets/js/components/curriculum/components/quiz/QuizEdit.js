import React, { Component } from 'react'
import TinyMCE from 'react-tinymce';
import axios from 'axios';
import * as api from './../../api';
import _ from 'lodash';
import QuizRelatedLecure from './QuizRelatedLecture';
import QuizAnswerEditorEdit from './QuizAnswerEditorEdit';

class QuizEdit extends Component {

    constructor(props) {
        super(props);
        this.state = {
            question: '',
            answers: [],
            checkAnswer: 0,
            relatedLecture: 0,
            blankAnswer: {content: '', reason: ''},
            reason: ''
        }

        this.addNewAnswer = this.addNewAnswer.bind(this);
        this.submitQuiz = this.submitQuiz.bind(this);
        this.handleChangeQuestion = this.handleChangeQuestion.bind(this);
        this.handleOpenQuizAddInEdit = this.handleOpenQuizAddInEdit.bind(this);
        this.deleteAnswer = this.deleteAnswer.bind(this);
        this.changeAnswer = this.changeAnswer.bind(this);
        this.addAnswer = this.addAnswer.bind(this);
        this.addReason = this.addReason.bind(this);
        this.selectRelated = this.selectRelated.bind(this)
        this.changeReason = this.changeReason.bind(this)
    }

    componentWillMount() {
        let {value, question} = this.props;
        let checkAnswer = parseInt(question.answer)
        let relatedLecture = parseInt(question.related_lecture)
        this.setState({
            question: question.content, 
            checkAnswer, 
            relatedLecture,
            reason: question.reason
        })

        axios.get(api.LIST_ANSWERS, {
            params: {questionId: question.id}
        })
        .then((r) => {
            if (r.status === 200) {
                let answers = r.data;
                //console.log(answers);

                if (answers.length === 1) {
                    answers.push(this.state.blankAnswer)
                    answers.push(this.state.blankAnswer)
                } else {
                    answers.push(this.state.blankAnswer)
                } 

                this.setState({answers: answers})
            }
        })
        .catch((e) => {
            console.log(e)
        })
    }

    addNewAnswer(i) {
        let {blankAnswer, answers} = this.state;
        let length = answers.length;
        if (length < 15 && i === (length-1)) {
            answers.push(blankAnswer);
            this.setState({answers})
        }
    }

    handleOpenQuizAddInEdit(value, status, question) {
        this.props.handleOpenQuizAddInEdit(value, status, question);
    }

    submitQuiz() {
        return event => {
            event.preventDefault();
            let {value} = this.props;
            let {question, answers, relatedLecture, reason} = this.state;
            if (question !== '') {
                //Add question first
                axios.post(api.UPDATE_QUESTION, {
                    question: this.props.question,
                    answers: this.state.answers,
                    content: question,
                    related_lecture: relatedLecture,
                    reason
                })
                .then((r) => {
                    //console.log(r);
                    let q = r.data;
                    this.props.handleOpenQuizAddInEdit(value, false, q);
                })
                .catch((e) => {
                    console.log(e)
                })
            }
        }
    }

    handleChangeQuestion(e) {
        let question = e.target.getContent();
        console.log(question);
        this.setState({question})
    }

    changeAnswer(checkAnswer) {
        let {answers} = this.state;

        _.forEach(answers, function(value, key) {
            answers[key].answer = 'N';
        });

        answers[checkAnswer].answer = 'Y';

        this.setState({answers})
    }

    selectRelated(relatedLecture) {
        this.setState({relatedLecture})
    }

    deleteAnswer(i) {
        let {answers} = this.state;
        let length = answers.length;
        if (length > 1) {
            let newAnswer = this.state.answers.filter((s, _idx) => _idx !== i)
            this.setState({
                answers: newAnswer,
            });
        }
    }

    addAnswer(value, index) {
        const newAnswers = this.state.answers.map((ans, i) => {
            if (index !== i) return ans;
            return { ...ans, content: value };
        });
      
        this.setState({ answers: newAnswers });
    }

    addReason(value, index) {
        const newAnswers = this.state.answers.map((ans, i) => {
            if (index !== i) return ans;
            return { ...ans, reason: value };
        });
      
        this.setState({ answers: newAnswers });
    }

    changeReason(e) {
        let reason = e.target.getContent();
        this.setState({reason})
    }

    render() {
        let {value} = this.props;
        let answers = this.state.answers.map((v, i) => {
            return (
                <div className="answer-content-wrapper" key={i}>
                    <div className="answer-check">
                        <label className="custom-control custom-radio">
                            <input 
                                type="radio" 
                                className="custom-control-input" 
                                name="answer"
                                checked={v.answer === 'Y'}
                                value={i}
                                onChange={() => this.changeAnswer(i)} 
                            />
                            <span className="custom-control-indicator"></span>
                        </label>
                    </div>
                    <QuizAnswerEditorEdit 
                        index={i}
                        answer={v}
                        addNewAnswer={this.addNewAnswer}
                        addAnswer={this.addAnswer}
                        addReason={this.addReason}
                    />
                    <div className="answer-toolbar">
                        <button
                            type="button"
                            onClick={() => this.deleteAnswer(i)}
                        >
                            <i className="fa-trash-o fa"></i>
                        </button>
                    </div>
                </div>
            )
        })

        return (
            <div className="lecture-add-more">
                <div className="content-type-close">
                    Thêm câu hỏi
                    <button
                        onClick={() => this.handleOpenQuizAddInEdit(value, false, {})}
                    ><i className="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div className="add-content-wrapper">
                    <form className="quiz-add-content" onSubmit={this.submitQuiz()}>
                        <p>Câu hỏi</p>
                        <TinyMCE
                            content={this.state.question}
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
                                // relative_urls: false,
                                // file_browser_callback : function(field_name, url, type, win) {
                                //     var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                //     var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                                //
                                //     var cmsURL = api.BASE_URL + 'cdn-filemanager?field_name=' + field_name;
                                //     if (type == 'image') {
                                //         cmsURL = cmsURL + "&type=Images";
                                //     } else {
                                //         cmsURL = cmsURL + "&type=Files";
                                //     }
                                //     tinyMCE.activeEditor.windowManager.open({
                                //         file : cmsURL,
                                //         title : 'Filemanager',
                                //         width : x * 0.8,
                                //         height : y * 0.8,
                                //         resizable : "yes",
                                //         close_previous : "no"
                                //     });
                                // },
                                language_url: api.BASE_URL + 'frontend/js/vi_VN.js'
                            }}
                            onChange={this.handleChangeQuestion}
                        />
                        <br/>
                        <div className="form-group answers-form-group">
                            <p>Câu trả lời</p>
                        </div>
                        {answers}
                        <span className="help-block">Viết lên đến 15 câu trả lời có thể và chỉ ra câu trả lời nào là tốt nhất.</span>

                        <div className="test-explain">
                            <label>Giải thích</label>
                            <TinyMCE
                                content={this.state.reason}
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
                                onChange={(event) => this.changeReason(event)}
                            />
                        </div>

                        <div className="form-group answer-related-relatedLecture">
                            <p>Bài học liên quan</p>

                            <QuizRelatedLecure 
                                cId={this.props.cId}
                                selectRelated={this.selectRelated}
                                selected={this.props.question.related_lecture}
                            />

                            <span className="help-block">Chọn một bài giảng video có liên quan để giúp sinh viên trả lời câu hỏi này.</span>
                        </div>
                        <div className="text-right form-actions">
                            <button className="btn btn-primary" type="submit"> Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        )
    }
}

export default QuizEdit;