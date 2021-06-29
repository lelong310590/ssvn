import React, {Component} from 'react';
import * as api from './../api';
import _ from 'lodash';
import axios from 'axios';
import TinyMCE from 'react-tinymce';

class CurriculumItemEdit extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            editTitle: '',
            editDescrition: '',
        }

        this.handleChangeEditTitle = this.handleChangeEditTitle.bind(this);
        this.handleChangeEditDesc = this.handleChangeEditDesc.bind(this);
        this.handleCloseEditItem = this.handleCloseEditItem.bind(this);
        this.onChangeEditItem = this.onChangeEditItem.bind(this);
        this.handleChangeEditDescQuiz = this.handleChangeEditDescQuiz.bind(this);
    }

    componentWillMount() {
        this.setState({
            editTitle: this.props.value.name,
            editDescrition: this.props.value.description
        })
    }

    handleChangeEditTitle(event) {
        let editTitle = event.target.value;
        if (!_.isNaN(editTitle)) {
            this.setState({editTitle})
        }
    }

    handleChangeEditDesc(event) {
        let editDescrition = event.target.value;
        this.setState({editDescrition})
    }

    handleChangeEditDescQuiz(e) {
        let editDescrition = e.target.getContent();
        this.setState({editDescrition})
    }

    handleCloseEditItem(value) {
        this.props.handleCloseEditItem(value);
    }

    onChangeEditItem(value) {
        return event => {
            event.preventDefault()
            let {editDescrition, editTitle} = this.state;
            if (!_.isNaN(editTitle)) {
                axios.post(api.UPDATE_ITEM, {
                    id: value.id,
                    name: editTitle,
                    description: editDescrition,
                })
                .then((response) => {
                    if (response.status === 200) {
                        this.props.onChangeEditItem(response.data)
                        this.handleCloseEditItem(value);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
            }
        }
    }

    renderTitle(val) {
        switch (val) {
            case 'section':
                return 'Phần';
            case 'lecture':
                return 'Bài học';
            case 'test':
                return 'Bài tập';
            case 'quiz': 
                return 'Trắc nghiệm';
            default:
                return 'Phần';
        }
    }

    render() {
        let {value} = this.props;
        return (
            <div className="form-wrapper">
                <form className="form-section" onSubmit={this.onChangeEditItem(value)}>
                    <div style={{display: 'flex'}}>
                        <div className="form-title">
                            {this.renderTitle(value.type)}
                        </div>
                        <div className="form-content">
                            <div className="form-group form-group-sm">
                                <input 
                                    maxLength="80" 
                                    placeholder="Nhập tiêu đề" 
                                    className="form-control" 
                                    type="text" 
                                    value={this.state.editTitle}
                                    onChange={this.handleChangeEditTitle}
                                    required
                                />
                            </div>

                            {value.type === 'section' &&
                                <div>
                                    <label className="control-label">Học viên sẽ có thể làm gì vào cuối phần này?</label>
                                    <div className="form-group form-group-sm">
                                        <input 
                                            maxLength="200" 
                                            placeholder="Nhập miêu tả" 
                                            className="form-control" 
                                            type="text"
                                            value={_.isNull(this.state.editDescrition) ? '' : this.state.editDescrition}
                                            onChange={this.handleChangeEditDesc}
                                        />
                                    </div>
                                </div>
                            }

                            {(value.type === 'quiz' || value.type === 'test') &&
                                <div style={{marginBottom: 15}}>
                                    <TinyMCE
                                        content={this.state.editDescrition}
                                        config={{
                                            toolbar: 'bold italic',
                                            menubar: false,
                                            statusbar: false,
                                            theme: 'modern'
                                        }}
                                        onChange={this.handleChangeEditDescQuiz}
                                    />
                                </div>
                            }

                        </div>
                    </div>
                    <div className="text-right form-actions">
                        <button 
                            className="btn btn-link"
                            onClick={() => this.handleCloseEditItem(value)}
                        > Đóng</button>
                        <button className="btn btn-primary"> Lưu lại</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default CurriculumItemEdit;