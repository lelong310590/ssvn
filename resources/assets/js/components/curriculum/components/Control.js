import React, {Component} from 'react';
import _ from 'lodash';
import * as api from './../api';
import axios from 'axios';
import QuizAdd from './quiz/QuizAdd';
import TestAdd from './test/TestAdd';
import {BASE_URL} from "../../const";

class Control extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            sectionTitle: '',
            sectionDesc: '',
            lectureTitle: '',
            lectureDesc: ''
        }
        this.sectionFormStatusListening = this.sectionFormStatusListening.bind(this)
        this.lectureFormStatusListening = this.lectureFormStatusListening.bind(this)
        this.addNewSection = this.addNewSection.bind(this);
        this.changeSectionTitle = this.changeSectionTitle.bind(this);
        this.changeSectionDesc = this.changeSectionDesc.bind(this);
        this.quizFormStatusListening = this.quizFormStatusListening.bind(this);
        this.testFormStatusListening = this.testFormStatusListening.bind(this)
        this.quizAdded = this.quizAdded.bind(this);
    }

    /**
     * Return props to parent component listen toggle status of section add form
     * @param {*} value 
     */
    sectionFormStatusListening(value) {
        this.props.sectionFormStatusListening(value)
    }

    /**
     * Return props to parent component listen toggle status of lecture add form
     * @param {*} value 
     */
    lectureFormStatusListening(value) {
        this.props.lectureFormStatusListening(value)
    }

    quizFormStatusListening(value) {
        this.props.quizFormStatusListening(value);
    }

    testFormStatusListening(value) {
        this.props.testFormStatusListening(value);
    }

    /**
     * Listen the changing of the section add form title field
     * then set new state to sectionTitle
     * @param {*} event 
     */
    changeSectionTitle(event) {
        let sectionTitle = event.target.value;
        if (!_.isNaN(sectionTitle)) {
            this.setState({sectionTitle})
        }
    }

    /**
     * Listen the changing of the section add form description field
     * then set new state to sectionDesc
     * @param {*} event 
     */
    changeSectionDesc(event) {
        let sectionDesc = event.target.value;
        if (!_.isNaN(sectionDesc)) {
            this.setState({sectionDesc})
        }
    }

    /**
     * Add new section
     * @param {*} event 
     */
    addNewSection(type) {
        return event => {
            event.preventDefault()
            let {sectionDesc, sectionTitle} = this.state;
            if (!_.isNaN(sectionTitle)) {
                axios.post(api.ADD_ITEM, {
                    course_id: this.props.cId,
                    name: this.state.sectionTitle,
                    description: this.state.sectionDesc,
                    type: type,
                    userid: this.props.userid
                })
                .then((response) => {
                    console.log(response);
                    if (response.status === 200) {
                        this.setState({
                            sectionTitle: '',
                            sectionDesc: '',
                        })
                        this.sectionFormStatusListening(false)
                        this.lectureFormStatusListening(false)
                        this.props.itemAdded(response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        }
    }

    quizAdded(value) {
        this.props.itemAdded(value);
    }

    render() {
        let showItemsAddButton = false;
        let {displayLectureAddForm, displayQuizAddForm} = this.props;
        if (displayLectureAddForm || displayQuizAddForm) { showItemsAddButton = true }
        return(
            <div className="curriculum-control">
                {this.props.displayLectureAddForm === true &&
                    <div className="form-wrapper">
                        <form className="form-section" onSubmit={this.addNewSection('lecture')}>
                            <div style={{display: 'flex'}}>
                                <div className="form-title">
                                    Bài học mới
                                </div>
                                <div className="form-content">
                                    <div className="form-group form-group-sm">
                                        <input 
                                            maxLength="80" 
                                            placeholder="Nhập tiêu đề" 
                                            className="form-control" 
                                            type="text" 
                                            value={this.state.sectionTitle}
                                            onChange={this.changeSectionTitle}
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="text-right form-actions">
                                <button 
                                    className="btn btn-link"
                                    onClick={() => this.lectureFormStatusListening(false)}
                                > Đóng</button>
                                <button 
                                    className="btn btn-primary"
                                    type="submit"
                                > Thêm bài học</button>
                            </div>
                        </form>
                    </div>
                }

                {this.props.displayQuizAddForm === true &&
                    <QuizAdd 
                        cId={this.props.cId}
                        quizFormStatusListening={this.quizFormStatusListening}
                        quizAdded={this.quizAdded}
                    />
                }

                {this.props.displayTestAddForm === true &&
                    <TestAdd 
                        cId={this.props.cId}
                        testFormStatusListening={this.testFormStatusListening}
                        quizAdded={this.quizAdded}
                        userid={this.props.userid}
                    />
                }

                {showItemsAddButton === false &&
                    <div className="button-group">

                        {this.props.courseType === 'normal' &&
                            <button
                                className="btn btn-outline-primary btn-50"
                                onClick={() => this.lectureFormStatusListening(true)}
                            >
                                <span className="fa fa-plus-square"></span> Thêm bài học
                            </button>
                        }

                        {1 === 0  &&
                            <button
                                className="btn btn-outline-primary btn-50"
                                onClick={() => this.quizFormStatusListening(true)}
                            >
                            <span className="fa fa-plus-square"></span> Thêm câu hỏi
                            </button>
                        }

                        <button 
                            className={`btn btn-outline-primary ${this.props.courseType === 'normal' ? 'btn-50' : 'btn-100'}`}
                            onClick={() => this.testFormStatusListening(true)}
                        >
                            <span className="fa fa-plus-square"></span> Thêm trắc nghiệm
                        </button>
                    </div>
                }

                {(this.props.displaySectionAddForm === false && this.props.courseType !== 'test' && this.props.courseType !== 'exam') &&
                    <div className="button-group">
                        <button 
                            className="btn btn-outline-primary btn-100"
                            onClick={() => this.sectionFormStatusListening(true)}
                        >
                            <span className="fa fa-plus-square"></span> Thêm phần
                        </button>
                    </div>
                }
                
                {this.props.displaySectionAddForm === true &&
                    <div className="form-wrapper">
                        <form className="form-section" onSubmit={this.addNewSection('section')}>
                            <div style={{display: 'flex'}}>
                                <div className="form-title">
                                    Phần mới
                                </div>
                                <div className="form-content">
                                    <div className="form-group form-group-sm">
                                        <input 
                                            maxLength="80" 
                                            placeholder="Nhập tiêu đề" 
                                            className="form-control" 
                                            type="text" 
                                            value={this.state.sectionTitle}
                                            onChange={this.changeSectionTitle}
                                            required
                                        />
                                    </div>
                                    <label className="control-label">Học viên sẽ có thể làm gì vào cuối phần này?</label>
                                    <div className="form-group form-group-sm">
                                        <input 
                                            maxLength="200" 
                                            placeholder="Nhập miêu tả" 
                                            className="form-control" 
                                            type="text"
                                            value={this.state.sectionDesc}
                                            onChange={this.changeSectionDesc}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="text-right form-actions">
                                <button 
                                    className="btn btn-link"
                                    onClick={() => this.sectionFormStatusListening(false)}
                                > Đóng</button>
                                <button className="btn btn-primary" type="submit"> Thêm phần</button>
                            </div>
                        </form>
                    </div>
                }

            </div>
        )
    }
}

export default Control;