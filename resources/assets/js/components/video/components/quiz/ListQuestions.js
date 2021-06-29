import React, {Component} from 'react';
import RawHtml from 'react-raw-html';
import {QUESTION_LENGTH} from "../../api";

class ListQuestions extends Component
{
    state = {
        sideListQuestion: [],
    };

    closeList = () => {
        this.props.closeList()
    };

    changeQuestionInList = (currentQuestion) => {
        this.props.changeQuestionInList(currentQuestion)
    };

    render() {
        let {questions, currentQuestion, answeredQuestions} = this.props;
        let questionElem = questions.map((question, index) => {
            let classStyle = '';
            if (currentQuestion === index) {
                classStyle = 'current'
            } else if (answeredQuestions.includes(question.id)) {
                classStyle = 'old'
            }

            return (
                <li key={index} className={`${classStyle}`}>
                    <div className="question-navigation-item" onClick={() => this.changeQuestionInList(index)}>
                        <div className="question-navigation-item-name">
                            <span className="question-navigation-title">Câu số {index + 1}</span>
                        </div>
                        <div className="question-navigation-item-description">
                            <RawHtml.div>{question.content.replace(/<[^>]+>/g, '').substring(0, 100)}</RawHtml.div>
                        </div>
                    </div>
                </li>
            )
        })

        let classStyle = this.props.showListQuestion === true ? 'question-panel-open': '';

        return(
            <div className={`question-panel ${classStyle}`}>
                <div className="question-panel-wrapper">
                    <p className="text-center question-panel-title">Danh sách câu hỏi</p>
                    <button
                        className="question-list-close"
                        onClick={() => this.closeList()}
                    >
                        <i className="fas fa-times"></i>
                    </button>
                </div>
                <div className="question-panel-list">
                    <ul className="question-panel-list-detail">
                        {questionElem}
                    </ul>
                </div>
            </div>
        )
    }
}

export default ListQuestions