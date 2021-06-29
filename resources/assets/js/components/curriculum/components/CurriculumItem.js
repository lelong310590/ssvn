import React, {Component} from 'react';
import {SortableContainer, SortableElement, arrayMove} from 'react-sortable-hoc';
import {Modal} from 'react-bootstrap';
import * as api from './../api';
import CurriculumItemEdit from './CurriculumItemEdit';
import CurriculumEditor from './CurriculumEditor';
import VideoUploadTabs from './VideoUploadTabs';
import axios from 'axios';
import LectureItemContent from './LectureItemContent';
import QuizOpenContent from './quiz/QuizOpenContent';
import QuizQuestionCreate from './quiz/QuizQuestionCreate';
import QuizContent from './quiz/QuizContent';
import QuizEdit from './quiz/QuizEdit';
import ResourceUpload from './ResourceUpload';
import TestEdit from "./test/TestEdit";
import TestOpenContent from "./test/TestOpenContent";
import Multichoice from "./test/Multichoice";
import MultichoiceEdit from "./test/MultichoiceEdit"

class CurriculumItem extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            showModal: false,
            curriculumItemId: 1,
            editTitle: '',
            editDescrition: '',
            question: ''
        }
        this.onSortEnd = this.onSortEnd.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleShowModal = this.handleShowModal.bind(this);
        this.handleDeleteItem = this.handleDeleteItem.bind(this);
        this.handleOpenEditItem = this.handleOpenEditItem.bind(this);
        this.handleCloseEditItem = this.handleCloseEditItem.bind(this);
        this.onChangeEditItem = this.onChangeEditItem.bind(this);
        this.handleOpenAddLecture = this.handleOpenAddLecture.bind(this);
        this.openDescriptionTinyMCE = this.openDescriptionTinyMCE.bind(this);
        this.closeTinyMce = this.closeTinyMce.bind(this);
        this.onSubmitTinyMCE = this.onSubmitTinyMCE.bind(this);
        this.handleContentStatus = this.handleContentStatus.bind(this);
        this.handleOpenVideoAdd = this.handleOpenVideoAdd.bind(this);
        this.uploadLecureContent = this.uploadLecureContent.bind(this);
        this.updateVideo = this.updateVideo.bind(this);
        this.changeStatusLecture = this.changeStatusLecture.bind(this);
        this.changeFreePreview = this.changeFreePreview.bind(this);
        this.handleOpenQuizAdd = this.handleOpenQuizAdd.bind(this);
        this.changeCurriculumStatus = this.changeCurriculumStatus.bind(this);
        this.onChangeMedia = this.onChangeMedia.bind(this);
        this.handleOpenQuizContent = this.handleOpenQuizContent.bind(this)
        this.questionAdded = this.questionAdded.bind(this)
        this.addNewQuestion = this.addNewQuestion.bind(this)
        this.onSortEndQuestion = this.onSortEndQuestion.bind(this);
        this.deleteQuestion = this.deleteQuestion.bind(this);
        this.handleEditQuestion = this.handleEditQuestion.bind(this)
        this.handleOpenQuizAddInEdit = this.handleOpenQuizAddInEdit.bind(this)
        this.questionEdited = this.questionEdited.bind(this);
        this.openResourceContent = this.openResourceContent.bind(this)
        this.deleteResource = this.deleteResource.bind(this)
        this.uploadNewResource = this.uploadNewResource.bind(this)
        this.onChangeResource = this.onChangeResource.bind(this);
        this.closeTestEdit = this.closeTestEdit.bind(this);
        this.testEdited = this.testEdited.bind(this);
        this.handleMultiQForm = this.handleMultiQForm.bind(this);
        this.handleMultiQFormEdit = this.handleMultiQFormEdit.bind(this);
        this.multipleEdited = this.multipleEdited.bind(this)
    }

    /**
     * Handle while complete the sortablejs
     * Update new index of curriculum array
     * @param {*} param0 
     */
    onSortEnd({oldIndex, newIndex}) {
        let items = arrayMove(this.props.items, oldIndex, newIndex);
        this.props.onSortEnd(items);

        axios.post(api.UPDATE_ON_SORT_END, {
            items,
            oldIndex,
            newIndex
        })
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error)
        })
    };

    onSortEndQuestion(questions, cur) {
        this.props.onSortEndQuestion(questions, cur);
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
    handleShowModal(id) {
        this.setState({ 
            showModal: true,
            curriculumItemId: id
        });
    }

    /**
     * Handle modal press delete
     * Send id to service then close modal
     * then pass a props back to parent component to delele item from array
     * @param {*} id 
     */
    handleDeleteItem(id) {
        axios.post(api.DELETE_ITEM, {
            id
        })
        .then((response) => {
            if (response.status === 200) {
                this.handleCloseModal();
                this.props.itemDeleted(id);
            }
        })
        .catch((error) => {
            console.log(error)
        })
    }

    handleOpenEditItem(value) {
        //console.log(value);
        this.setState({
            editTitle: value.name,
            editDescrition: value.description
        })
        this.props.handleOpenEditItem(value);
    }

    handleCloseEditItem(value) {
        this.props.handleCloseEditItem(value);
    }

    onChangeEditItem(respJson) {
        this.props.onChangeEditItem(respJson)
    }

    handleOpenAddLecture(value, status) {
        this.props.handleOpenAddLecture(value, status);
    }

    openDescriptionTinyMCE(value, status) {
        this.props.openDescriptionTinyMCE(value, status);
    }

    closeTinyMce(value, status) {
        this.props.closeTinyMce(value, status);
    }

    onSubmitTinyMCE(value, description) {
        this.props.onSubmitTinyMCE(value, description);
    }

    handleContentStatus(value, status) {
        this.props.handleContentStatus(value, status);
    }

    handleOpenVideoAdd(value, status) {
        this.props.handleOpenVideoAdd(value, status)
    }

    uploadLecureContent(file, value) {
        this.props.uploadLecureContent(file, value)
    }

    updateVideo(value, status) {
        this.props.updateVideo(value, status);
    }

    changeStatusLecture(value) {
        this.props.changeStatusLecture(value);
    }

    changeFreePreview(id, value) {
        this.props.changeFreePreview(id, value);
    }

    handleOpenQuizAdd(value, status) {
        this.props.handleOpenQuizAdd(value, status);
    }

    handleOpenQuizAddInEdit(value, status, question) {
        this.props.handleOpenQuizAddInEdit(value, status, question);
    }

    changeCurriculumStatus(value) {
        this.props.changeCurriculumStatus(value);
    }

    onChangeMedia(value, media) {
        this.props.onChangeMedia(value, media);
    }

    handleOpenQuizContent(value, status) {
        this.props.handleOpenQuizContent(value, status)
    }

    questionAdded(question, curId) {
        this.props.questionAdded(question, curId)
    }

    addNewQuestion(id) {
        this.props.addNewQuestion(id)
    }

    deleteQuestion(question, curriculum) {
        this.props.deleteQuestion(question, curriculum);
    }

    handleEditQuestion(question, curriculum) {
        this.props.handleEditQuestion(question, curriculum)
        this.setState({question})
    }

    questionEdited(question, curriculum) {
        this.props.handleEditQuestion(question, curriculum)
        this.setState({question: ''})
    }

    openResourceContent(value, status) {
        this.props.openResourceContent(value, status);
    }

    deleteResource(id, curriculum) {
        this.props.deleteResource(id, curriculum);
    }

    uploadNewResource(resource, curriculum) {
        this.props.uploadNewResource(resource, curriculum)
    }

    onChangeResource(curriculum, resource) {
        this.props.onChangeResource(curriculum, resource);
    }

    closeTestEdit(value) {
        this.props.closeTestEdit(value)
    }

    testEdited(value) {
        this.props.testEdited(value);
    }

    handleMultiQForm(value, status) {
        this.props.handleMultiQForm(value, status)
    }

    handleMultiQFormEdit(value, status) {
        this.props.handleMultiQFormEdit(value, status)
    }

    multipleEdited(value, status, q) {
        this.props.multipleEdited(value, status, q)
    }

    render() {
        let indexSection = 0;
        let indexLecture = 0;

        const SortableItem = SortableElement(({value, i}) => {

            let typeName = '';
            if (value.type === 'lecture') { typeName = 'Bài học '; indexLecture += 1 }
            if (value.type === 'section') { typeName = 'Phần '; indexSection += 1 }
            if (value.type === 'quiz') { typeName = 'Câu hỏi ' }
            if (value.type === 'test') { typeName = 'Bài tập ' }

            let typeIcon = 'file';
            if (value.type === 'section') { typeIcon = 'file' }
            if (value.type === 'lecture') { typeIcon = 'video' }
            if (value.type === 'quiz' || value.type === 'test') { typeIcon = 'check' }

            let hasContent = (value.content !== null && !_.isEmpty(value.content)) ? true : false;
            //console.log(hasContent);
            
            return(
                <li className={value.type === 'section' ? 'curriculum-item' : 'curriculum-item curriculum-lecture'}>
                    <div className="section-editor">
                        {value.onEdit === false ? (
                            <div className="item-bar">
                                <div className="item-bar-title">
                                    <span className="item-bar-status">
                                        {(value.type !== 'section' && value.status === 'disable') ? (
                                            <i className="fa fa-exclamation-triangle" style={{color: '#f59c49'}}></i>
                                        ) : (<span></span>) } 

                                        {(value.type !== 'section' && value.status === 'active') ? (
                                            <i className="fa fa-check-circle" style={{color: '#007791', marginRight: '5px'}}></i>
                                        ) : (<span></span>) } 

                                        {value.status === 'disable'&&
                                            <span> Lưu nháp </span>
                                        } 
                                        {typeName} 
                                        {value.status === 'active' ? (
                                            <span>
                                                {value.type ==='section' && indexSection}
                                                {value.type ==='lecture' && indexLecture}
                                            </span>
                                        ) : (<span></span>)}:
                                    </span>
                                    <span className="item-bar-name">
                                        {typeIcon === 'file' && <span className="fa fa-file-text-o item-bar-name-icon"></span>}
                                        {typeIcon === 'video' && <span className="fa fa-play-circle-o item-bar-name-icon"></span>}
                                        {typeIcon === 'check' && <span className="fa fa-check-square-o item-bar-name-icon"></span>}
                                        
                                        <span>{value.name}</span>
                                    </span>
                                    <button 
                                        className="btn btn-xs item-bar-button"
                                        onClick={() => this.handleOpenEditItem(value)}
                                    ><i className="fa-pencil fa"></i></button>

                                    {(this.props.coursetype !== 'test' || value.type !== 'section')  &&
                                        <button
                                            className="btn btn-xs item-bar-button"
                                            onClick={() => this.handleShowModal(value.id)}
                                        ><i className="fa-trash-o fa"></i></button>
                                    }

                                </div>
                                {value.type === 'lecture' ? (
                                    <div>
                                        <div className="item-bar-right">
                                            {!hasContent &&
                                                <button 
                                                    className="btn btn-sm btn-outline-primary"
                                                    onClick={() => this.handleContentStatus(value, true)}
                                                ><i className="fa fa-plus"></i> Thêm nội dung</button>
                                            }

                                            {value.preview === 'active' &&
                                                <div className="preview-status">
                                                    (Xem miễn phí)
                                                </div>
                                            }
                                            
                                            {value.show === false ? (
                                                <button 
                                                    className="btn btn-xs item-bar-button item-bar-show"
                                                    onClick={() => this.handleOpenAddLecture(value, true)}
                                                ><i className="fa-chevron-down fa"></i></button>
                                            ) : (
                                                <button 
                                                    className="btn btn-xs item-bar-button item-bar-show"
                                                    onClick={() => this.handleOpenAddLecture(value, false)}
                                                ><i className="fa-chevron-up fa"></i></button>
                                            )}
                                                
                                        </div>
                                        <span className="btn btn-xs item-bar-button"><i className="fa-bars fa"></i></span>
                                    </div>
                                ) : (
                                    <div>
                                        {value.type !== 'section' && 
                                            <div className="item-bar-right">
                                                {!hasContent &&
                                                    <button 
                                                        className="btn btn-sm btn-outline-primary"
                                                        onClick={() => this.handleContentStatus(value, true)}
                                                    ><i className="fa fa-plus"></i> Thêm câu hỏi</button>
                                                }
                                                
                                                {hasContent && 
                                                    <button 
                                                        className="btn btn-xs item-bar-button item-bar-show"
                                                        onClick={() => this.handleOpenQuizContent(value, !value.show)}
                                                    ><i className="fa-chevron-down fa"></i></button>
                                                }
                                            </div>
                                        }
                                        <span className="btn btn-xs item-bar-button"><i className="fa-bars fa"></i></span>
                                    </div>
                                )}
                            </div>

                        ) : (
                            <div className="form-wrapper">
                                {value.type === 'test' ? (
                                    <TestEdit
                                        value={value}
                                        closeTestEdit={this.closeTestEdit}
                                        testEdited={this.testEdited}
                                    />
                                ) : (
                                    <CurriculumItemEdit
                                        value={value}
                                        handleCloseEditItem={this.handleCloseEditItem}
                                        onChangeEditItem={this.onChangeEditItem}
                                        description={value.description}
                                    />
                                )}
                            </div>
                        )}
                    </div>

                    {value.displayQuizForm === true && 
                        <div>
                            {value.onEditQuestion === false ? (
                                <QuizQuestionCreate 
                                    value={value}
                                    handleOpenQuizAdd={this.handleOpenQuizAdd}
                                    cId={this.props.cId}
                                    userid={this.props.userid}
                                    questionAdded={this.questionAdded}
                                />
                            ) : (
                                <QuizEdit 
                                    value={value}
                                    handleOpenQuizAddInEdit={this.handleOpenQuizAddInEdit}
                                    cId={this.props.cId}
                                    userid={this.props.userid}
                                    question={this.state.question}
                                    questionEdited={this.questionEdited}
                                />
                            )}
                        </div>
                    }

                    {value.displayMultiForm === true &&
                        <Multichoice
                            handleMultiQForm={this.handleMultiQForm}
                            value={value}
                            cId={this.props.cId}
                            userid={this.props.userid}
                            questionAdded={this.questionAdded}
                        />
                    }

                    {value.displayTestFormEdit === true &&
                        <MultichoiceEdit
                            value={value}
                            cId={this.props.cId}
                            userid={this.props.userid}
                            question={this.state.question}
                            handleMultiQFormEdit={this.handleMultiQFormEdit}
                            multipleEdited={this.multipleEdited}
                        />
                    }

                    {value.showContent === true &&
                        <div>
                            {value.type === 'lecture' &&
                                <div className="lecture-add-more">
                                    <div className="content-type-close">
                                        Chọn kiểu nội dung
                                        <button
                                            onClick={() => this.handleContentStatus(value, false)}
                                        ><i className="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                    <div className="add-content-wrapper">
                                        <p className="text-center">Chọn loại nội dung chính. Các tệp và liên kết có thể được thêm dưới dạng tài nguyên. Tìm hiểu về các loại nội dung.</p>
                                        <ul className="add-content-wrapper-list text-center">
                                            <li className="content-type-selector">
                                                <button
                                                    onClick={() => this.handleOpenVideoAdd(value, true)}
                                                >
                                                    <i className="fa fa-play-circle-o content-type-icon"></i>
                                                    <i className="fa fa-play-circle-o content-type-icon-hover"></i>
                                                    <span className="">Video</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            }
                            
                            {value.type === 'quiz' && 
                                <QuizOpenContent 
                                    value={value}
                                    handleContentStatus={this.handleContentStatus}
                                    handleOpenQuizAdd={this.handleOpenQuizAdd}
                                />
                            }

                            {value.type === 'test' &&
                                <TestOpenContent
                                    value={value}
                                    handleContentStatus={this.handleContentStatus}
                                    handleOpenQuizAdd={this.handleOpenQuizAdd}
                                    handleMultiQForm={this.handleMultiQForm}
                                />
                            }

                        </div>
                    }

                    {value.showVideoContent === true &&
                        <div className="lecture-add-more">
                            <div className="content-type-close">
                                Thêm Video
                                <button
                                    onClick={() => this.handleOpenVideoAdd(value, false)}
                                ><i className="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                            <div className="add-content-wrapper">
                                <VideoUploadTabs 
                                    userid={this.props.userid}
                                    value={value}
                                    uploadLecureContent={this.uploadLecureContent}
                                    changeCurriculumStatus={this.changeCurriculumStatus}
                                    onChangeMedia={this.onChangeMedia}
                                />
                            </div>
                        </div>
                    }

                    {value.showResourceContent === true &&
                        <div className="lecture-add-more">
                            <div className="content-type-close">
                                Thêm tài liệu
                                <button
                                    onClick={() => this.openResourceContent(value, false)}
                                ><i className="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                            <div className="add-content-wrapper">
                                <ResourceUpload 
                                    userid={this.props.userid}
                                    value={value}
                                    uploadLecureContent={this.uploadLecureContent}
                                    changeCurriculumStatus={this.changeCurriculumStatus}
                                    onChangeResource={this.onChangeResource}
                                    uploadNewResource={this.uploadNewResource}
                                />
                            </div>
                        </div>
                    }

                    {value.show === true && 
                        <div>
                            {value.type !== 'lecture' ? (
                                <QuizContent 
                                    question={value.content}
                                    curriculum={value}
                                    addNewQuestion={this.addNewQuestion}
                                    onSortEndQuestion={this.onSortEndQuestion}
                                    deleteQuestion={this.deleteQuestion}
                                    handleEditQuestion={this.handleEditQuestion}
                                    changeStatusLecture={this.changeStatusLecture}
                                />
                            ) : (
                                <div className="lecture-add-more">
                                {value.showEditor === false ? (
                                    <div>
                                        {!_.isNull(value.content) && (
                                            <LectureItemContent 
                                                value={value}
                                                showVideoContent={this.showVideoContent}
                                                updateVideo={this.updateVideo}
                                                changeStatusLecture={this.changeStatusLecture}
                                                changeFreePreview={this.changeFreePreview}
                                                deleteResource={this.deleteResource}
                                            />
                                        )}
                                        <button 
                                            className="btn btn-outline-primary"
                                            onClick={() => this.openDescriptionTinyMCE(value, true)}
                                        >
                                            <i className="fa fa-plus"></i> Thêm miêu tả
                                        </button>
                                        <button 
                                            className="btn btn-outline-primary"
                                            onClick={() => this.openResourceContent(value, true)}
                                        >
                                            <i className="fa fa-plus"></i> Thêm tài liệu
                                        </button>
                                    </div>
                                ) : (
                                    <div>
                                        <CurriculumEditor
                                            title={'Miêu tả bài học'}
                                            value={value}
                                            closeTinyMce={this.closeTinyMce}
                                            onSubmitTinyMCE={this.onSubmitTinyMCE}
                                        />
                                        <button 
                                            className="btn btn-outline-primary"
                                            onClick={() => this.openResourceContent(value, true)}
                                        >
                                            <i className="fa fa-plus"></i> Thêm tài liệu
                                        </button>
                                    </div>
                                )}
                                </div>
                            )}
                        </div>
                    }
                </li>
            )}
        );

        const SortableList = SortableContainer(({items}) => {
            
            return (
                <ul className="curriculum-list">
                    {items.map((value, index) => (
                        <SortableItem key={`item-${index}`} index={index} value={value} i={index}/>
                    ))}

                    <Modal show={this.state.showModal} onHide={this.handleCloseModal}>
                        <Modal.Header>
                            <Modal.Title>Bạn có chắc chắn xóa </Modal.Title>
                            <button 
                                type="button" 
                                className="close"
                                onClick={() => this.handleCloseModal()}
                            >
                                <span aria-hidden="true">×</span>
                                <span className="sr-only">Close</span>
                            </button>
                        </Modal.Header>
                        <Modal.Body>
                            <p>
                                Bạn sắp xóa một chương trình giảng dạy. Bạn có chắc chắn muốn tiếp tục không?
                            </p>
                        </Modal.Body>
                        <Modal.Footer>
                            <button 
                                type="reset" 
                                className="btn btn-tertiary"
                                onClick={() => this.handleCloseModal()}
                            >Đóng</button>
                            <button 
                                type="submit" 
                                className="btn btn-secondary"
                                onClick={() => this.handleDeleteItem(this.state.curriculumItemId)}
                            >Xóa</button>
                        </Modal.Footer>
                    </Modal>
                </ul>
            );
        });

        return(
            <SortableList 
                items={this.props.items} 
                onSortEnd={this.onSortEnd} 
                shouldCancelStart={(e) => {
                    const disabledElements = [
                        'input', 'textarea', 'select', 'option', 'button', 'div', 'a', 'ul', 'li',
                        'table', 'thead', 'tbody', 'tr', 'td', 'th', 'p', 'label', 'b', 'i'
                    ];

                    if (disabledElements.indexOf(e.target.tagName.toLowerCase()) !== -1) {
                        return true; // Return true to cancel sorting
                    }
                }}
            />
        )
    }
}

export default CurriculumItem;