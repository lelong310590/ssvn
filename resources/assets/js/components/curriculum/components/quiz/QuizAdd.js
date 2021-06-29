import React, {Component} from 'react';
import TinyMCE from 'react-tinymce';
import * as api from './../../api';

class QuizAdd extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            quizTitle: '',
            quizDescription: ''
        }

        this.quizFormStatusListening = this.quizFormStatusListening.bind(this);
        this.addNewQuiz = this.addNewQuiz.bind(this);
        this.changeQuizTitle = this.changeQuizTitle.bind(this);
        this.changeQuizDesc = this.changeQuizDesc.bind(this);
    }

    changeQuizTitle(e) {
        let quizTitle = e.target.value;
        this.setState({
            quizTitle
        })
    }

    changeQuizDesc(e) {
        let quizDescription = e.target.getContent();
        this.setState({
            quizDescription
        })
    }

    quizFormStatusListening(value) {
        this.props.quizFormStatusListening(value);
    }

    addNewQuiz(type) {
        return event => {
            event.preventDefault()
            let {quizDescription, quizTitle} = this.state;
            if (!_.isNaN(quizTitle)) {
                axios.post(api.ADD_ITEM, {
                    course_id: this.props.cId,
                    name: quizTitle,
                    description: quizDescription,
                    type: type
                })
                .then((response) => {
                    if (response.status === 200) {
                        this.setState({
                            quizTitle: '',
                            quizDescription: '',
                        })
                        this.props.quizFormStatusListening(false);
                        this.props.quizAdded(response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        }
    }

    render() {
        return(
            <div className="form-wrapper">
                <form className="form-section" onSubmit={this.addNewQuiz('quiz')}>
                    <div style={{display: 'flex'}}>
                        <div className="form-title">
                            Câu hỏi
                        </div>
                        <div className="form-content">
                            <div className="form-group form-group-sm">
                                <input 
                                    maxLength="80" 
                                    placeholder="Nhập tiêu đề" 
                                    className="form-control" 
                                    type="text" 
                                    value={this.state.quizTitle}
                                    onChange={this.changeQuizTitle}
                                    required
                                />
                            </div>
                            <TinyMCE
                                content={this.state.quizDescription}
                                config={{
                                    toolbar: 'bold italic',
                                    menubar: false,
                                    statusbar: false,
                                    theme: 'modern'
                                }}
                                onChange={this.changeQuizDesc}
                            />
                        </div>
                    </div>
                    <div className="text-right form-actions">
                        <button 
                            className="btn btn-link"
                            onClick={() => this.quizFormStatusListening(false)}
                        > Đóng</button>
                        <button className="btn btn-primary" type="submit"> Thêm câu hỏi</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default QuizAdd;