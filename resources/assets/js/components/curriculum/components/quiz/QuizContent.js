import React, { Component } from 'react'
import {SortableContainer, SortableElement, arrayMove} from 'react-sortable-hoc';
import * as api from './../../api';
import {Modal} from 'react-bootstrap';
import RawHtml from "react-raw-html";
import axios from "axios/index";

class QuizContent extends Component {

    constructor(props) {
        super(props);
        this.state = {
            showModal: false,
            questionSelected: ''
        }

        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleShowModal = this.handleShowModal.bind(this);
        this.onSortEnd = this.onSortEnd.bind(this);
        this.addNewQuestion = this.addNewQuestion.bind(this);
        this.deleteQuestion = this.deleteQuestion.bind(this);
        this.handleEditQuestion = this.handleEditQuestion.bind(this);
        this.changeStatusLecture  = this.changeStatusLecture .bind(this)
    }

     /**
     * Handle while close modal
     * simply change the state
     */
    handleCloseModal() {
        this.setState({ 
            showModal: false 
        });
    }

    /**
     * Handle while open modal
     * Pass and set id to curriculum state
     * @param {*} id 
     */
    handleShowModal(question) {
        this.setState({ 
            showModal: true,
            questionSelected: question
        });
    }

    addNewQuestion(id) {
        this.props.addNewQuestion(id);
    }

    onSortEnd({oldIndex, newIndex}) {
        let items = arrayMove(this.props.question, oldIndex, newIndex);
        this.props.onSortEndQuestion(items, this.props.curriculum);

        axios.post(api.UPDATE_QUESTION_ON_SORT_END, {
            items
        })
        .then((response) => {
            //console.log(response);
        })
        .catch((error) => {
            console.log(error)
        })
    };

    deleteQuestion(value) {
        axios.post(api.DELETE_QUESTION, {
            id: value.id
        })
        .then((response) => {
            if (response.status === 200) {
                this.props.deleteQuestion(value, this.props.curriculum)
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    handleEditQuestion(question, curriculum) {
        this.props.handleEditQuestion(question, curriculum)
    }

    changeStatusLecture(value) {
        axios.post(api.UPDATE_STATUS, {
            value
        })
        .then((resp) => {
            //console.log(value);
            if (resp.status === 200) {
                let data = {
                    lecture: value,
                    section: {
                        id: resp.data.section.id,
                        status: resp.data.section.status
                    }
                };
                this.props.changeStatusLecture(data);
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    render() {

        const SortableItem = SortableElement(({value, i}) => {
            return (
                <li>
                    <div className="question-item-wrapper">
                        <div className="question-item">
                            <b>{i + 1}. </b>
                            <RawHtml.span>{value.content.replace(/<[^>]+>/g, '')}</RawHtml.span>
                            <small>{value.type == 'multi' ? ' - Nhi???u ????p ??n': ''}</small>
                        </div>
                        <div className="question-item-panel">
                            <button className="btn btn-xs item-bar-button">
                                <i className="fa-bars fa"></i>
                            </button>
                            <button 
                                className="btn btn-xs item-bar-button"
                                onClick={() => this.handleShowModal(value)}
                            >
                                <i className="fa-trash-o fa"></i>
                            </button>
                            <button 
                                className="btn btn-xs item-bar-button"
                                onClick={() => this.handleEditQuestion(value, this.props.curriculum)}
                            >
                                <i className="fa-pencil fa"></i>
                            </button>
                        </div>
                    </div>
                </li>
            )
        })

        const SortableList = SortableContainer(({items}) => {
            return (
                <ul className="curriculum-list">
                    {items.map((value, index) => (
                        <SortableItem key={`item-${index}`} index={index} value={value} i={index}/>
                    ))}

                    <Modal show={this.state.showModal} onHide={this.handleCloseModal}>
                        <Modal.Header>
                            <Modal.Title>B???n c?? ch???c ch???n x??a </Modal.Title>
                            <button 
                                type="button" 
                                className="close"
                                onClick={() => this.handleCloseModal()}
                            >
                                <span aria-hidden="true">??</span>
                                <span className="sr-only">Close</span>
                            </button>
                        </Modal.Header>
                        <Modal.Body>
                            <p>
                                B???n s???p x??a m???t c??u h???i. B???n c?? ch???c ch???n mu???n ti???p t???c kh??ng?
                            </p>
                        </Modal.Body>
                        <Modal.Footer>
                            <button 
                                type="reset" 
                                className="btn btn-tertiary"
                                onClick={() => this.handleCloseModal()}
                            >????ng</button>
                            <button 
                                type="submit" 
                                className="btn btn-secondary"
                                onClick={() => this.deleteQuestion(this.state.questionSelected)}
                            >X??a</button>
                        </Modal.Footer>
                    </Modal>
                </ul>
            );
        });

        let {curriculum} = this.props;

        return (
            <div className="lecture-add-more">
                <div className="lecture-content-container">
                    <div className="lecture-content-wrapper">
                        <div className="quiz-content">
                            C??u h???i
                            <button
                                onClick={() => this.addNewQuestion(this.props.curriculum)}
                            >Th??m c??u h???i m???i</button>
                        </div>
                    </div>
                    <div>
                        <div className="lecture-content-action">
                            {curriculum.status === 'disable' &&
                                <button 
                                    onClick={() => this.changeStatusLecture(curriculum)}
                                    className="btn btn-danger"
                                >Xu???t b???n</button>
                            }

                            {curriculum.status === 'active' &&
                                <button 
                                    onClick={() => this.changeStatusLecture(curriculum)}
                                    className="btn btn-outline-danger"
                                >Ng???ng xu???t b???n</button>
                            }
                        </div>
                    </div>
                </div>
                <div className="question-list">
                    <SortableList 
                        items={this.props.question} 
                        onSortEnd={this.onSortEnd} 
                        shouldCancelStart={(e) => {
                            const disabledElements = [
                                'input', 'textarea', 'select', 'option', 'button', 'a', 'ul', 'i'
                            ];

                            if (disabledElements.indexOf(e.target.tagName.toLowerCase()) !== -1) {
                                return true; // Return true to cancel sorting
                            }
                        }}
                    />
                </div>
            </div>
        )
    }
}

export default QuizContent;
