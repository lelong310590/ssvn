import React, {Component} from 'react';
import Control from './Control';
import CurriculumItem from './CurriculumItem';
import * as api from './../api';
import axios from 'axios';

class Curriculum extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            displaySectionAddForm: false,
            displayLectureAddForm: false,
            displayQuizAddForm: false,
            displayTestAddForm: false,
            cId: 1,
            items: [],
            userid: this.props.userid,
            courseType: this.props.coursetype
        }

        this.sectionFormStatusListening = this.sectionFormStatusListening.bind(this);
        this.lectureFormStatusListening = this.lectureFormStatusListening.bind(this);
        this.itemDeleted = this.itemDeleted.bind(this);
        this.itemAdded = this.itemAdded.bind(this);
        this.handleOpenEditItem = this.handleOpenEditItem.bind(this);
        this.handleCloseEditItem = this.handleCloseEditItem.bind(this);
        this.onChangeEditItem = this.onChangeEditItem.bind(this);
        this.onSortEnd = this.onSortEnd.bind(this);
        this.handleOpenAddLecture = this.handleOpenAddLecture.bind(this);
        this.openDescriptionTinyMCE = this.openDescriptionTinyMCE.bind(this);
        this.onSubmitTinyMCE = this.onSubmitTinyMCE.bind(this);
        this.handleContentStatus = this.handleContentStatus.bind(this);
        this.handleOpenVideoAdd = this.handleOpenVideoAdd.bind(this);
        this.uploadLecureContent = this.uploadLecureContent.bind(this);
        this.updateVideo = this.updateVideo.bind(this);
        this.changeStatusLecture = this.changeStatusLecture.bind(this);
        this.changeFreePreview = this.changeFreePreview.bind(this);
        this.quizFormStatusListening = this.quizFormStatusListening.bind(this);
        this.handleOpenQuizAdd = this.handleOpenQuizAdd.bind(this);
        this.changeCurriculumStatus = this.changeCurriculumStatus.bind(this);
        this.onChangeMedia = this.onChangeMedia.bind(this);
        this.handleOpenQuizContent = this.handleOpenQuizContent.bind(this);
        this.questionAdded = this.questionAdded.bind(this)
        this.addNewQuestion = this.addNewQuestion.bind(this)
        this.onSortEndQuestion = this.onSortEndQuestion.bind(this)
        this.deleteQuestion = this.deleteQuestion.bind(this)
        this.handleEditQuestion = this.handleEditQuestion.bind(this);
        this.handleOpenQuizAddInEdit = this.handleOpenQuizAddInEdit.bind(this);
        this.openResourceContent = this.openResourceContent.bind(this)
        this.deleteResource = this.deleteResource.bind(this);
        this.uploadNewResource = this.uploadNewResource.bind(this);
        this.onChangeResource = this.onChangeResource.bind(this);
        this.testFormStatusListening = this.testFormStatusListening.bind(this)
        this.closeTestEdit = this.closeTestEdit.bind(this);
        this.testEdited = this.testEdited.bind(this);
        this.handleMultiQForm = this.handleMultiQForm.bind(this);
        this.handleMultiQFormEdit = this.handleMultiQFormEdit.bind(this);
        this.multipleEdited = this.multipleEdited.bind(this);
    }

    /**
     * Set course_id while component mount
     * and fetch curriculum item data from service
     */
    componentWillMount() {
        let url = window.location.pathname;
        let cId = parseInt(_.split(url, '/')[3]);
        this.setState({cId});

        axios.get(api.GET_ALL_ITEMS, {
            params: {
                cId
            }
        })
        .then((response) => {
            if (response.status === 200) {
                this.setState({
                    items: response.data
                })
            }
        })
        .catch((error) => {
            console.log(error);
        });
    }

    /**
     * Change state to toggle section add form 
     * @param {*} value 
     */
    sectionFormStatusListening(value) {
        this.setState({
            displaySectionAddForm: value
        })
    }

    quizFormStatusListening(value) {
        this.setState({
            displayQuizAddForm: value,
            displaySectionAddForm: false
        })
    }

    /**
     * Change state to toggle lecture add form
     * @param {*} value 
     */
    lectureFormStatusListening(value) {
        this.setState({
            displayLectureAddForm: value
        })
    }

    /**
     * Remove delelted item from array
     * @param {*} id 
     */
    itemDeleted(id) {
        let {items} = this.state;
        _.remove(items, function(n) {
            return n.id === id;
        });
        this.setState({items})
    }

    itemAdded(val) {
        console.log(val);
        let {items} = this.state;
        items.push(val);
        this.setState({items})
    }

    /**
     * Close all item first (set onEdit value in all item in array = false) 
     * Then open selected item
     * @param {*} value 
     */
    handleOpenEditItem(value) {
        let {items} = this.state;
        items.map((v) => {
            v.onEdit = false
        })
        let index = _.indexOf(items, value);
        value.onEdit = true;
        value.show = false;
        items[index] = value;
        this.setState({items});
    }

    handleCloseEditItem(value) {
        let {items} = this.state;
        let index = _.indexOf(items, value);
        value.onEdit = false;
        items[index] = value;
        this.setState({items});
    }

    /**
     * 
     * @param {*} value 
     */
    onChangeEditItem(value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        items[index] = value;
        this.setState({items})
    }

    onSortEnd(items) {
        this.setState({items})
    }

    onSortEndQuestion(questions, cur) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', cur.id]);
        items[index].content = questions;
        this.setState({items})
    }

    handleOpenAddLecture(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.show = status;
        items[index] = value;
        this.setState({items})
    }

    openDescriptionTinyMCE(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.showEditor = status;
        items[index] = value;
        this.setState({items})
    }

    onSubmitTinyMCE(value, description) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.description = description;
        value.showEditor = false;
        items[index] = value;
        this.setState({items})
    }

    handleContentStatus(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.showContent = status;
        value.show = false;
        items[index] = value;
        this.setState({items})
    }

    handleOpenVideoAdd(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.showVideoContent = status;
        value.showContent = false;
        items[index] = value;
        this.setState({items})
    }

    uploadLecureContent(file, value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.content = file;
        value.showVideoContent = false;
        value.show = true;
        this.setState({items})
    }

    updateVideo(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        value.show = false;
        value.showVideoContent = status;
        this.setState({items})
    }

    changeStatusLecture(value) {
        let lecture = value.lecture;
        let section = value.section;
        let {items} = this.state;
        let index = _.findIndex(items, ['id', lecture.id]);
        //console.log(lecture);
        let status = lecture.status;
        if (status === 'disable') {
            lecture.status = 'active'
        } else if (status === 'active') {
            lecture.status = 'disable'
        }

        if (section.id !== 0) {
            let sidx = _.findIndex(items, ['id', section.id]);
            items[index] = lecture;
            if (_.has(items[sidx], 'status')) {
                items[sidx].status = section.status;
            }
        }

        this.setState({items})
    }

    changeFreePreview(id, value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', id]);
        items[index].preview = value;
        this.setState({items})
    }

    handleOpenQuizAdd(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.displayQuizForm = status;
        value.showContent = false;
        value.onEditQuestion = false;
        items[index] = value;
        this.setState({items})
    }

    changeCurriculumStatus(value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        items[index].status = value.status;
        this.setState({items})
    }

    onChangeMedia(value, media) {
        console.log(media);
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        items[index].showVideoContent = false;
        items[index].show = true;
        items[index].preview = 'disable';
        items[index].content = media
        this.setState({items})
    }

    handleOpenQuizContent(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.show = status;
        items[index] = value;
        this.setState({items})
    }

    addNewQuestion(value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.show = false;
        value.showContent = true;
        items[index] = value;
        this.setState({items})
    }

    deleteQuestion(question, curriculum) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curriculum.id])
        let questions = items[index].content;
        _.remove(questions, function(n) {
            return n.id === question.id;
        });
        items[index].content = questions;
        if (_.isEmpty(questions)) {
            items[index].show = false
        }
        this.setState({items})
    }

    handleEditQuestion(question, curriculum) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curriculum.id])
        items[index].show = false;
        if (question.type === 'multi') {
            items[index].displayTestFormEdit = true;
        } else {
            items[index].displayQuizForm = true;
        }
        items[index].onEditQuestion = true;
        this.setState({items})
    }

    questionAdded(question, curId) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curId]);
        let content = items[index].content;
        console.log(content);
        content.push(question);
        items[index].content = content;
        items[index].displayQuizForm = false;
        items[index].displayMultiForm = false;
        items[index].show = true;
        this.setState({items})
    }

    handleOpenQuizAddInEdit(value, status, question) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.displayQuizForm = status;
        value.showContent = false;
        value.show = true;
        if (!_.isEmpty(question)) {
            //update content of curriculum = question
            let content = items[index].content;
            let idx = _.findIndex(content, ['id', question.id]);
            content[idx] = question;
            value.content = content;
        }

        items[index] = value;
        this.setState({items})
    }

    openResourceContent(value, status) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.showResourceContent = status;
        value.show = !status;
        items[index] = value;
        this.setState({items})
    }

    deleteResource(id, curriculum) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curriculum.id]) 
        let resource = items[index].resource;
        _.remove(resource, function(n) {
            return n.id === id;
        });
        this.setState({items})
    }

    uploadNewResource(r, curriculum) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curriculum.id]) 
        let resource = items[index].resource;
        resource.push(r);
        items[index].show = true;
        items[index].showResourceContent = false;
        this.setState({items});
    }

    onChangeResource(curriculum, r) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', curriculum.id]) 
        let resource = items[index].resource;
        resource.push(r);
        items[index].show = true;
        items[index].showResourceContent = false;
        this.setState({items});
    }
    
    testFormStatusListening(value) {
        this.setState({
            displayTestAddForm: value,
            displaySectionAddForm: false
        })
    }

    closeTestEdit(value) {
        let {items} = this.state;
        let id = value.id;
        let status = value.status;
        let index = _.findIndex(items, ['id', id]);
        items[index].onEdit = status;
        this.setState({items})
    }

    testEdited(value) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id]);
        items[index] = value;
        this.setState({items})
    }

    handleMultiQForm(value, status) {
        //console.log(value);
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.displayMultiForm = status;
        value.showContent = false;
        value.onEditQuestion = false;
        items[index] = value;
        this.setState({items})
    }

    handleMultiQFormEdit(value, status) {
        //console.log(value, status);
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.displayTestFormEdit = status;
        items[index] = value;
        this.setState({items})
    }

    multipleEdited(value, status, question) {
        let {items} = this.state;
        let index = _.findIndex(items, ['id', value.id])
        value.displayTestFormEdit = status;
        value.showContent = false;
        value.show = true;
        if (!_.isEmpty(question)) {
            //update content of curriculum = question
            let content = items[index].content;
            let idx = _.findIndex(content, ['id', question.id]);
            content[idx] = question;
            value.content = content;
        }

        items[index] = value;
        this.setState({items})
    }

    render() {
        return(
            <div className="curriculum-editor">
                
                <CurriculumItem
                    items={this.state.items}
                    itemDeleted={this.itemDeleted}
                    handleOpenEditItem={this.handleOpenEditItem}
                    handleCloseEditItem={this.handleCloseEditItem}
                    onChangeEditItem={this.onChangeEditItem}
                    onSortEnd={this.onSortEnd}
                    onSortEndQuestion={this.onSortEndQuestion}
                    handleOpenAddLecture={this.handleOpenAddLecture}
                    openDescriptionTinyMCE={this.openDescriptionTinyMCE}
                    closeTinyMce={this.openDescriptionTinyMCE}
                    onSubmitTinyMCE={this.onSubmitTinyMCE}
                    handleContentStatus={this.handleContentStatus}
                    handleOpenVideoAdd={this.handleOpenVideoAdd}
                    userid={this.props.userid}
                    uploadLecureContent={this.uploadLecureContent}
                    updateVideo={this.updateVideo}
                    changeStatusLecture={this.changeStatusLecture}
                    changeFreePreview={this.changeFreePreview}
                    handleOpenQuizAdd={this.handleOpenQuizAdd}
                    cId={this.state.cId}
                    changeCurriculumStatus={this.changeCurriculumStatus}
                    onChangeMedia={this.onChangeMedia}
                    handleOpenQuizContent={this.handleOpenQuizContent}
                    questionAdded={this.questionAdded}
                    addNewQuestion={this.addNewQuestion}
                    deleteQuestion={this.deleteQuestion}
                    handleEditQuestion={this.handleEditQuestion}
                    handleOpenQuizAddInEdit={this.handleOpenQuizAddInEdit}
                    openResourceContent={this.openResourceContent}
                    deleteResource={this.deleteResource}
                    uploadNewResource={this.uploadNewResource}
                    onChangeResource={this.onChangeResource}
                    closeTestEdit={this.closeTestEdit}
                    testEdited={this.testEdited}
                    handleMultiQForm={this.handleMultiQForm}
                    handleMultiQFormEdit={this.handleMultiQFormEdit}
                    multipleEdited={this.multipleEdited}
                    coursetype={this.props.coursetype}
                />

                <Control 
                    displaySectionAddForm={this.state.displaySectionAddForm}
                    displayLectureAddForm={this.state.displayLectureAddForm}
                    displayQuizAddForm={this.state.displayQuizAddForm}
                    displayTestAddForm={this.state.displayTestAddForm}
                    sectionFormStatusListening={this.sectionFormStatusListening}
                    lectureFormStatusListening={this.lectureFormStatusListening}
                    quizFormStatusListening={this.quizFormStatusListening}
                    testFormStatusListening={this.testFormStatusListening}
                    cId={this.state.cId}
                    itemAdded={this.itemAdded}
                    userid={this.props.userid}
                    courseType={this.props.coursetype}
                />
            </div>
        )
    }
}

export default Curriculum;