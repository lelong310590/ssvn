import React, {Component} from 'react';
import QuestionListEmpty from "./QuestionListEmpty";
import _ from 'lodash';
import {LIST_QUESTION} from "../../api";

import FormPostQuestion from "./FormPostQuestion";
import List from "./List";
import Detail from "./Detail";

class QuestionList extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            showFormQuestion: false,
            questions: [],
            toDetail: false,
            detailQuestion: {},
            keywords: ''
        }
        this.toggleFormQuest = this.toggleFormQuest.bind(this)
        this.addedQuestion = this.addedQuestion.bind(this)
        this.toDetail = this.toDetail.bind(this)
        this.backToList = this.backToList.bind(this)
        this.onSearch = this.onSearch.bind(this)
        this.handleDeleteQuestion = this.handleDeleteQuestion.bind(this)
        this.closeConfirmation = this.closeConfirmation.bind(this)
    }

    toggleFormQuest(status) {
        this.setState({
            showFormQuestion: status
        })
    }

    addedQuestion(value) {
        let {questions} = this.state;
        value.isNew = true;
        questions.push(value);
        this.setState({questions})
    }

    toDetail(value) {
        this.setState({
            toDetail: true,
            detailQuestion: value
        })
    }

    backToList() {
        this.setState({
            toDetail: false
        })
    }

    onSearch(e) {
        let keywords = e.target.value;
        this.setState({keywords})
    }

    componentWillMount() {
        let {courseid, lectureid, userid} = this.props;
        axios.get(LIST_QUESTION, {
            params: {
                courseid, lectureid, userid,
            }
        })
        .then((resp) => {
            //console.log(resp)
            if (resp.status === 200) {
                this.setState({
                    questions: resp.data
                })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    handleDeleteQuestion(id) {
        let {questions} = this.state;
        let questionIdx = _.findIndex(questions, ['id', id]);
        _.pullAt(questions, questionIdx);
        this.setState({questions})
    }

    closeConfirmation(status, id) {
        let {questions} = this.state;
        let questionIdx = _.findIndex(questions, ['id', id]);
        questions[questionIdx].isNew = false;
        this.setState({questions})
    }

    render() {
        let {questions, toDetail, detailQuestion, showFormQuestion, keywords} = this.state;
        let length = questions.length;
        if (keywords && keywords.length) {
            questions = _.filter(questions, function (o) {
                return o.title.toLowerCase().indexOf(keywords.toLowerCase()) !== -1
            })
        }

        let ListQuestionElem = questions.map((value, index) => {
            return (
                <List
                    key={index}
                    question={value}
                    toDetail={this.toDetail}
                    closeConfirmation={this.closeConfirmation}
                />
            )
        })

        return(
            <div className={'lecture-question-wrapper'}>
                {showFormQuestion === false ? (
                    <div>
                        {toDetail ? (
                            <Detail
                                question={detailQuestion}
                                backToList={this.backToList}
                                userid={this.props.userid}
                                handleDeleteQuestion={this.handleDeleteQuestion}
                            />
                        ) : (
                            <div>
                                <form className={'lecture-question-search-form'}>
                                    <div className={'form-group'}>
                                        <input
                                            type="text"
                                            className={'form-control'}
                                            placeholder={'Tìm kiếm câu hỏi'}
                                            value={keywords}
                                            onChange={(e) => this.onSearch(e)}
                                        />
                                    </div>
                                    <div className="lecture-question-sub">
                                        <div className="lecture-question-count">
                                            <p>{length} câu hỏi trong bài học này</p>
                                        </div>
                                        <div className="lecture-question-addnew">
                                            <button
                                                className="btn btn-group"
                                                onClick={() => this.toggleFormQuest(true)}
                                            >Thêm câu hỏi</button>
                                        </div>
                                    </div>
                                </form>

                                <div className="lecture-question-list">
                                    {length > 0 ? (
                                        <div className="lecture-question-list-wrapper">
                                            {ListQuestionElem}
                                        </div>
                                    ) : (
                                        <div className="lecture-question-empty">
                                            <QuestionListEmpty/>
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}

                    </div>
                ) : (
                    <FormPostQuestion
                        toggleFormQuest={this.toggleFormQuest}
                        lectureid={this.props.lectureid}
                        courseid={this.props.courseid}
                        userid={this.props.userid}
                        addedQuestion={this.addedQuestion}
                    />
                )}
            </div>
        )
    }
}

export default QuestionList