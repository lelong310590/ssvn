import React, { Component } from 'react'
import {Panel} from 'react-bootstrap';
import * as api from './../../api';
import axios from 'axios';
import {convertDuration} from './../../../curriculum/helper';
import { Link } from "react-router-dom";

class CourseSingleSection extends Component {

    constructor(props) {
        super(props);
        this.state = {
            lecture: [],
            activeKey: '1',
            slug: ''
        }

        this.downloadResource = this.downloadResource.bind(this);
        this.changeLectureProgressStatus = this.changeLectureProgressStatus.bind(this);
    }

    componentWillMount() {
        let {courseid, userid} = this.props;
        axios.get(api.GET_LECTURE_IN_SECTION, {
            params: {
                section: this.props.data.id,
                courseid,
                userid
            }
        })
        .then((res) => {
            if (res.status === 200) {
                let lecture = res.data.lecture;
                let course = res.data.course;
                this.setState({
                    lecture,
                    slug: course.slug
                })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    downloadResource(url) {
        window.open(url);
    }

    changeLectureProgressStatus(courseid, userid, status) {
        let section = this.props.courseid;
        axios.post(api.CHANGE_PROCESS, {
            section,
            courseid,
            userid,
            status
        })
        .then((resp) => {
            if (resp.status === 200) {
                let {lecture} = this.state;
                let lectureId = resp.data.id;
                let idx = _.findIndex(lecture, ['id', lectureId]);
                lecture[idx].get_process = resp.data.get_process;
                this.setState({lecture})
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    render() {
        let { data, index, userid, searchResults } = this.props;
        let { lecture } = this.state;

        const matchedLectures = _.intersectionWith(lecture, searchResults, (lecture1, lecture2) => lecture1.id === lecture2.id);

        let lectureElem = matchedLectures.map((lec, idx) => {

            let resource = lec.get_media;
            resource = _.filter(resource, function(o) { return o.type != 'video/mp4' });
            let resourceElem = resource.map((r, i) => {
                return(
                    <li key={i}>
                        <a onClick={() => this.downloadResource(api.BASE_URL + r.url)}>
                            <i className="fa fa-download" aria-hidden="true"></i>
                            {r.name}
                        </a>
                    </li>
                )
            })

            let completeStyle = (this.props.currentLecture == lec.id) ? 'lecture-complete' : '';
            let duration = (!_.isEmpty(lec.get_media)) ? convertDuration(lec.get_media[0].duration) : '';
            let haveStatus = !_.isEmpty(lec.get_process) ? lec.get_process[0].status : null;
            let status = false;
            if (!_.isNull(haveStatus)) {
                status = (lec.get_process[0].status === 3) ? true : false
            }
            return(
                <li className={'lecture-item ' + completeStyle} key={idx}>
                    <a className="lecture-item-link" href={`/${this.state.slug}/hoc/bai-hoc/${lec.id}`}>
                        <span style={{display: 'flex', alignItems: 'center'}}>
                            <span className="lecture-icon">
                                {lec.type === 'lecture' &&
                                    <i className="fa fa-play"></i>
                                }

                                {lec.type === 'quiz' &&
                                    <i className="fas fa-bolt"></i>
                                }

                                {lec.type === 'test' &&
                                    <i className="far fa-file-alt"></i>
                                }
                            </span>
                            <span className="lecture-title">
                                <span style={{marginRight: 5}}>{lec.type === 'lecture' ? idx + 1 + '. ' : ''}</span>
                                {lec.name}
                            </span>
                        </span>
                        <span style={{display: 'flex', alignItems: 'center'}}>
                            {lec.type === 'lecture' &&
                                <span className="lecture-time">
                                    {duration}
                                </span>
                            }

                        </span>
                    </a>

                    {status ? (
                        <span
                            className={`lecture-process lecture-process-success`}
                            onClick={() => this.changeLectureProgressStatus(lec.id, userid, false)}
                        >
                            <i className="fa fa fa-check"></i>
                        </span>
                    ) : (
                        <span
                            className="lecture-process"
                            onClick={() => this.changeLectureProgressStatus(lec.id, userid, true)}
                        >
                            <i className="fa fa fa-check"></i>
                        </span>
                    )}

                    {!_.isEmpty(resource) &&
                        <ul className="lecture-resource-list">
                            {resourceElem}
                        </ul>
                    }
                </li>
            )
        })

        return (
            <span>
                {
                    matchedLectures.length > 0 &&
                    <Panel id="curriculum-panel" defaultExpanded>
                        <Panel.Heading>
                            <Panel.Title toggle>
                                <div className="curriculum-navigator-section-status">
                                    <span className="cur-section">Phần: {index + 1}</span>
                                    <span className="cur-status">
                                    <span className="current-cur-status">{this.props.returnCurrentLecture.index}</span>
                                    <span>/{this.state.lecture.length}</span>
                                </span>
                                </div>
                                <div className="curriculum-navigator-section-title">
                                    <span>{data.name}</span>
                                </div>
                            </Panel.Title>
                        </Panel.Heading>
                        <Panel.Collapse>
                            <Panel.Body>
                                <ul className="lecture-body">
                                    {lectureElem}
                                </ul>
                            </Panel.Body>
                        </Panel.Collapse>
                    </Panel>
                }
            </span>
        )
    }
}

export default CourseSingleSection;
