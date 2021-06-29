import React, {Component} from 'react'
import TinyMCE from 'react-tinymce';
import * as api from './../../api';
import axios from 'axios';
import _ from 'lodash';
import MutichoiceEditorEdit from "./MultichoiceEditorEdit";

class MultichoiceEdit extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            question: '',
            answers: [],
            blankAnswer: {content: '', check: 'N'},
            explain: '',
            knowledgeArea: '',
            questionId: ''
        };
        this.handleChangeQuestion = this.handleChangeQuestion.bind(this);
        this.handleChangeExplain = this.handleChangeExplain.bind(this);
        this.handleMultiQFormEdit = this.handleMultiQFormEdit.bind(this);
        this.addNewAnswer = this.addNewAnswer.bind(this);
        this.handleChangeKnowledgeArea = this.handleChangeKnowledgeArea.bind(this);
        this.deleteAnswer = this.deleteAnswer.bind(this);
        this.addAnswer = this.addAnswer.bind(this);
        this.changeAnswer = this.changeAnswer.bind(this);
    }

    componentWillMount() {
        let {value, question} = this.props;
        let explain = question.reason;
        let knowledgeArea = question.knowledge_area;
        this.setState({
            question: question.content,
            explain,
            knowledgeArea,
        });

        axios.get(api.LIST_ANSWERS, {
            params: {questionId: question.id}
        })
            .then((r) => {
                if (r.status === 200) {
                    let answers = r.data;

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


    handleChangeQuestion(e) {
        let question = e.target.getContent();
        this.setState({question})
    }

    deleteAnswer(i) {
        let {answers} = this.state;
        let length = answers.length;
        if (length > 1) {
            let newAnswer = this.state.answers.filter((s, _idx) => _idx !== i);
            this.setState({
                answers: newAnswer,
            });
        }
    }

    handleChangeExplain(e) {
        let explain = e.target.value;
        this.setState({explain})
    }

    handleMultiQFormEdit(value, status) {
        this.props.handleMultiQFormEdit(value, status)
    }

    handleChangeKnowledgeArea(e) {
        let knowledgeArea = e.target.value;
        this.setState({knowledgeArea})
    }

    addNewAnswer(index) {
        let {blankAnswer, answers} = this.state;
        let length = answers.length;
        if (length < 15 && index === (length-1)) {
            answers.push(blankAnswer);
            this.setState({answers})
        }
    }

    addAnswer(content, index) {
        const newAnswers = this.state.answers.map((ans, i) => {
            if (index !== i) return ans;
            return { ...ans, content: content };
        });

        this.setState({ answers: newAnswers });
    }

    changeAnswer(value, index) {
        const newAnswers = this.state.answers.map((ans, i) => {
            if (index !== i) return ans;
            return { ...ans, answer: value };
        });
        console.log(newAnswers);
        this.setState({ answers: newAnswers });
    }

    submitTest(event) {
        event.preventDefault();
        let {value} = this.props;
        let {question, answers, explain, knowledgeArea} = this.state;
        let check = _.filter(answers, { 'answer': 'Y' });
        if (question !== '' && !_.isEmpty(check)) {
            //Add question first
            axios.post(api.UPDATE_TEST_QUESTION, {
                question,
                answers,
                explain,
                knowledgeArea,
                curriculum_item: value.id,
                owner: this.props.userid,
                id: this.props.question.id
            })
            .then((r) => {
                console.log(r)
                let q = r.data;
                if (r.status === 200) {
                    //add answer
                    this.props.multipleEdited(value, false, q);
                }
            })
            .catch((e) => {
                console.log(e)
            })
        }
    }

    render() {
        let {value} = this.props;
        let {answers} = this.state;
        let answersElem = answers.map((v, i) => {
            return (
                <div className={'answer-content-wrapper'} key={i}>
                    <MutichoiceEditorEdit
                        answer={v}
                        index={i}
                        addNewAnswer={this.addNewAnswer}
                        deleteAnswer={this.deleteAnswer}
                        changeAnswer={this.changeAnswer}
                        addAnswer={this.addAnswer}
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
                    Thêm câu trắc nghiệm
                    <button
                        onClick={() => {this.handleMultiQFormEdit(value, false)}}
                    ><i className="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div className="add-content-wrapper">
                    <form className="quiz-add-content" onSubmit={(event) => this.submitTest(event)}>
                        <p>Câu hỏi</p>
                        <TinyMCE
                            content={this.state.question}
                            config={{
                                plugins: 'autolink link image lists print preview fullscreen',
                                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | image | fullscreen',
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
                            onChange={this.handleChangeQuestion}
                        />
                        <br/>
                        <div className="form-group answers-form-group">
                            <p>Câu trả lời</p>
                        </div>
                        {answersElem}
                        <span className="help-block">Viết lên đến 15 câu trả lời có thể và chỉ ra câu trả lời nào là tốt nhất.</span>
                        <div className="form-group answer-related-relatedLecture">
                            <p>Giải thích</p>

                            <input
                                maxLength="600"
                                placeholder="Giải thích"
                                className="form-control"
                                type="text"
                                value={this.state.explain || ''}
                                onChange={(event) => this.handleChangeExplain(event)}
                            />

                            <span className="help-block">Giải thích tại sao câu trả lời đúng là lựa chọn tốt nhất.</span>
                        </div>

                        <div className="form-group answer-related-relatedLecture">
                            <p>Phạm vi kiến thức ( Có thể bỏ trống )</p>

                            <input
                                maxLength="600"
                                placeholder="Phạm vi kiến thức liên quan"
                                className="form-control"
                                type="text"
                                value={this.state.knowledgeArea || ''}
                                onChange={(event) => this.handleChangeKnowledgeArea(event)}
                            />
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

export default MultichoiceEdit;