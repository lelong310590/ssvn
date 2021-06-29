import React, { Component } from 'react'
import axios from 'axios';
import * as api from './../../curriculum/api';
import _ from 'lodash';

class VideoHeader extends Component {

    constructor(props) {
        super(props);
        this.state = {
            section_index: 1,
            lecture_index: 1,
            resources: 0
        }

        this.toggleList = this.toggleList.bind(this);
        this.backtoDashboard = this.backtoDashboard.bind(this);
    }

    componentWillReceiveProps(props) {
        axios.get(api.GET_LECTURE_INFO, {
            params: {
                id: this.props.currentLecture.id
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                let section = resp.data.section;
                let lecture = this.props.currentLecture;
                let listLecture = resp.data.list_lecture;
                let list = props.list;
                let index = _.findIndex(list, ['id', section.id]);
                let lectureIndex = _.findIndex(listLecture, ['id', lecture.id]);
                let resources = resp.data.resources;
                this.setState({
                    section_index: index + 1,
                    lecture_index: lectureIndex + 1,
                    resources
                })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    toggleList() {
        this.props.toggleList()
    }

    backtoDashboard() {
        let base_url = window.location.origin;
        let sub_url = window.location.pathname.split( '/' )[1];
        let destination = base_url + '/' + sub_url + '?tab=2';
        window.location.href = destination;
    }

    //header-left-open
    render() {
        let classStyle = this.props.showList ? 'header-left-open' : ''
        return (
            <div className={`player-header ${classStyle}`}>
                <div className="player-header-content">
                    <div className="player-header-gradient"></div>
                    <div className="player-header-button-group">
                        <div className="curriculum-navigation-button">
                            <div className="sidenav-toggle-button-group">
                                <div className="course-info-container">
                                    <button
                                        className="btn btn-control toggle-btn"
                                        onClick={() => this.toggleList()}
                                    >
                                        <i className="fas fa-list-ul"></i>
                                    </button>
                                    <div className="course-info">
                                        <span className="course-info-title">{this.props.currentLecture.name}</span>
                                        <span className="course-info-section"> Phần {this.state.section_index + 1}, Bài {this.state.lecture_index} </span>
                                    </div>
                                    {this.state.resources > 0 &&
                                        <div className="course-resource">
                                            <i className="far fa-folder-open"></i>
                                            Có tài liệu đính kèm
                                        </div>
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="player-header-backto-dashboard">
                        <span onClick={() => this.backtoDashboard()}>Về trang Khóa đào tạo</span>
                    </div>
                </div>
            </div>
        )
    }
}

export default VideoHeader;
