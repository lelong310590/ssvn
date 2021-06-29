import React, {Component} from 'react'
import Video from './Video';
import CourseItemList from './CourseItemList';
import VideoHeader from './VideoHeader';
import axios from 'axios';
import * as api from './../api';
import Quiz from "./quiz/Quiz";
import {BrowserRouter as Router, Route, Link} from "react-router-dom";
import VideoContent from "./VideoContent";

class Single extends Component {
    state = {
        list: [],
        courseId: this.props.courseid,
        userId: this.props.userid,
        currentLecture: this.props.lecture,
        listLecture: [],
        loading: true,
        showList: false,
        type: this.props.type,
        status: this.props.status,
        returnCurrentLecture: {index: 1},
        searchResults: [],
    };

    componentDidMount() {

        let {doexam} = this.props;

        let currentUrl = window.location.href;

        if (parseInt(doexam) === 1) {
            let urlArray = currentUrl.split('/');
            let urlArrayLength = urlArray.length - 1;

            if (urlArray[urlArrayLength] !== 'result') {
                window.location.href = currentUrl + '/test/result';
            }

        }

        let {courseId} = this.state;
        axios.get(api.GET_LIST_SECTION, {
            params: {
                cId: courseId
            }
        })
            .then((res) => {
                if (res.status === 200) {
                    this.setState({
                        list: res.data.section,
                        listLecture: res.data.lecture,
                        searchResults: res.data.lecture,
                    })
                }
            })
            .catch((err) => {
                console.log(err);
            })

        let {lecture, userid, courseid} = this.props;
        axios.post(api.LAST_PROCESSS, {
            lecture, userid, courseid
        })
            .then((resp) => {
                console.log(resp)
            })
            .catch((err) => {
                console.log(err)
            })
    }

    loadingComplete = () => {
        this.setState({
            loading: false
        })
    };

    toggleList = () => {
        let {showList} = this.state;
        this.setState({showList: !showList})
    };

    returnCurrentLecture = (value) => {
        this.setState({
            returnCurrentLecture: value
        })
    };

    onSearch = ({ lecture }) => {
        this.setState({
            searchResults: lecture,
        })
    };

    render() {
        return (
            <div>
                {this.state.loading === true &&
                <div className={'loading-wrapper'}>
                    <div className="loading-inner">
                        <i className="fas fa-spinner"></i>
                    </div>
                </div>
                }
                <div>
                    <CourseItemList
                        list={this.state.list}
                        currentLecture={this.props.lecture}
                        courseid={this.props.courseid}
                        showList={this.state.showList}
                        returnCurrentLecture={this.state.returnCurrentLecture}
                        userid={this.props.userid}
                        onSearch={this.onSearch}
                        searchResults={this.state.searchResults}
                    />

                    <VideoContent
                        toggleList={this.toggleList}
                        showList={this.state.showList}
                        courseid={this.props.courseid}
                        lectureid={this.props.lecture}
                        userid={this.props.userid}
                        type={this.props.type}
                        status={this.props.status}
                        loadingComplete={this.loadingComplete}
                        returnCurrentLecture={this.returnCurrentLecture}
                        isexam={this.props.isexam}
                        timestart={this.props.timestart}
                        timeend={this.props.timeend}
                        doexam={this.props.doexam}
                    />
                </div>
            </div>
        )
    }
}

export default Single;
