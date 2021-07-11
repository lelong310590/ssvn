import React, {Component} from 'react';
import TinyMCE from 'react-tinymce';
import * as api from './../../api';
import axios from 'axios';
import _ from 'lodash';
import QuizAnswerEditor from './QuizAnswerEditor';
import QuizRelatedLecure from './QuizRelatedLecture';

class QuizQuestionCreate extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            question: '',
            answers: [
                {content: '', reason: ''},
                {content: '', reason: ''},
                {content: '', reason: ''},
            ],
            checkAnswer: 0,
            relatedLecture: 0,
            blankAnswer: {content: '', reason: ''},
            reason: ''
        }
        this.handleOpenQuizAdd = this.handleOpenQuizAdd.bind(this)
        this.handleChangeQuestion = this.handleChangeQuestion.bind(this)
        this.addNewAnswer = this.addNewAnswer.bind(this)
        this.deleteAnswer = this.deleteAnswer.bind(this)
        this.submitQuiz = this.submitQuiz.bind(this)
        this.selectRelated = this.selectRelated.bind(this)
        this.addAnswer = this.addAnswer.bind(this)
        this.addReason = this.addReason.bind(this)
    }

    handleOpenQuizAdd(value, status) {
        this.props.handleOpenQuizAdd(value, status);
    }

    handleChangeQuestion(e) {
        let question = e.target.getContent();
        this.setState({question})
    }

    selectRelated(relatedLecture) {
        this.setState({relatedLecture})
    }

    addNewAnswer(i) {
        let {blankAnswer, answers} = this.state;
        let length = answers.length;
        if (length < 15 && i === (length-1)) {
            answers.push(blankAnswer);
            this.setState({answers})
        }
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

    changeAnswer(checkAnswer) {
        this.setState({checkAnswer})
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

    submitQuiz(event) {
        event.preventDefault();
        let {value} = this.props;
        let {question, answers, relatedLecture, checkAnswer, reason} = this.state;
        //console.log(answers);
        let answerContent = answers[checkAnswer].content;
        if (question !== '' && checkAnswer !== '' && answerContent !== '') {
            //Add question first
            axios.post(api.ADD_QUESTION, {
                content: question,
                curriculum_item: value.id,
                related_lecture: relatedLecture,
                owner: this.props.userid,
                reason
            })
            .then((r) => {
                let q = r.data;
                if (r.status === 200) {
                        //add answer
                    axios.post(api.ADD_ANSWERS, {
                        answers,
                        questionId: r.data.id,
                        answer: checkAnswer,
                    })
                    .then((resp) => {
                        this.props.questionAdded(q, value.id);
                    })
                    .catch((err) => console.log(err))
                }
                
            })
            .catch((e) => {
                console.log(e)
            })
        }
    }

    changeReason(e) {
        let reason = e.target.getContent();
        this.setState({reason})
    }

    render() {
        let {value} = this.props;
        let {answers} = this.state;
        let answersElem = answers.map((v, i) => {
            return (
                <div className="answer-content-wrapper" key={i}>
                    <div className="answer-check">
                        <label className="custom-control custom-radio">
                            <input 
                                type="radio"
                                className="custom-control-input" 
                                name="answer"
                                checked={this.state.checkAnswer === i } 
                                value={i}
                                onChange={() => this.changeAnswer(i)} 
                            />
                            <span className="custom-control-indicator"></span>
                        </label>
                    </div>
                    <QuizAnswerEditor 
                        index={i}
                        answer={v}
                        addNewAnswer={this.addNewAnswer}
                        addAnswer={this.addAnswer}
                        addReason={this.addReason}
                    />
                    <div className="answer-toolbar">
                        <button
                            onClick={() => this.deleteAnswer(i)}
                            type="button"
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
                    Thêm câu trắc nghiệm
                    <button
                        onClick={() => this.handleOpenQuizAdd(value, false)}
                    ><i className="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div className="add-content-wrapper">
                    <form className="quiz-add-content" onSubmit={(event) => this.submitQuiz(event)}>
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
                                                    console.log(response.data);
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
                            onChange={this.handleChangeQuestion}
                        />
                        <br/>
                        <div className="form-group answers-form-group">
                            <p>Câu trả lời</p>
                        </div>
                        {answersElem}
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
                                                    console.log(response.data);
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

export default QuizQuestionCreate;