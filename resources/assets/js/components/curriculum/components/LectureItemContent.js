import React, {Component} from 'react';
import _ from 'lodash';
import {convertDuration} from './../helper';
import axios from 'axios';
import * as api from './../api';
import ToggleButton from 'react-toggle-button'

class LectureItemContent extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            rejectReason: false,
        }
        this.updateVideo = this.updateVideo.bind(this);
        this.changeStatusLecture = this.changeStatusLecture.bind(this);
        this.changeFreePreview = this.changeFreePreview.bind(this);
        this.deleteResource = this.deleteResource.bind(this)
    }

    updateVideo(value, status) {
        this.props.updateVideo(value, status);
    }

    changeFreePreview(value) {
        console.log(value);
        let preview = (value.preview === 'active') ? 'disable' : 'active';
        axios.post(api.UPDATE_PREVIEW, {
            value
        })
        .then((resp) => {
            //console.log(resp);
            if (resp.status === 200) {
                this.props.changeFreePreview(value.id, preview)
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    changeStatusLecture(value) {
        axios.post(api.UPDATE_STATUS, {
            value
        })
        .then((resp) => {
            if (resp.status === 200) {
                let data = {
                    lecture: value,
                    section: {
                        id: resp.data.section.id,
                        status: resp.data.section.status
                    }
                }
                this.props.changeStatusLecture(data);
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    deleteResource(id, curriculum) {
        axios.post(api.SET_NULL_RESOURCE, {id})
        .then((r) => {
            if (r.status === 200) {
                this.props.deleteResource(id, curriculum);
            }
        })
        .catch((e) => {
            console.log(e);
        })
    }

    render() {
        let {value} = this.props;
        let content = value.content;
        let className = content.status === 'processing' ? "success" : "fail";
        let switchToggle = (value.preview) === 'active' ? true : false;

        let resourceElem = value.resource.map((file, index) => {
            return (
                <div key={index} className="resource-item">
                    <div>
                        <i className="fa fa-download"></i> {file.name}
                    </div>
                    <div className="resource-item-delete">
                        <button
                            onClick={() => this.deleteResource(file.id, value)}
                        >
                            <i className="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            )
        })

        return(
            <div>
                {content.status === 'active' ? (
                    <div>
                        <div className="lecture-content-container">
                            <div className="lecture-content-wrapper">
                                <img className="img-fluid" src={content.thumbnail} width={110}/>
                                <div className="lecture-content-info">
                                    <p className="lecture-content-title"><b>{content.name}</b></p>
                                    <p className="lecture-content-duration">
                                        {convertDuration(content.duration)}
                                    </p>
                                    <button
                                        onClick={() => this.updateVideo(value, true)}
                                    >
                                        <i className="fa fa-pencil"></i> Thay n???i dung
                                    </button>
                                </div>
                            </div>
                            <div>
                                <div className="lecture-content-action">
                                    {value.status === 'disable' &&
                                        <button 
                                            onClick={() => this.changeStatusLecture(value)}
                                            className="btn btn-danger"
                                        >Xu???t b???n</button>
                                    }

                                    {value.status === 'active' &&
                                        <button 
                                            onClick={() => this.changeStatusLecture(value)}
                                            className="btn btn-outline-danger"
                                        >Ng???ng xu???t b???n</button>
                                    }
                                </div>
                                <div className="toogle-lecture">
                                    <span>Xem mi???n ph??</span>
                                    <div className="toggle-item">
                                        <ToggleButton
                                            value={switchToggle}
                                            onToggle={() => this.changeFreePreview(value)}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!_.isEmpty(value.resource) &&
                            <div className="downloadable-resource">
                                <p><b>T??i li???u ????nh k??m</b></p>
                                {resourceElem}
                            </div>
                        }
                    </div>
                ) : (
                    <div className="table-responsive uploaded-table-result">
                        <table className="table">
                            <thead>
                                <tr>
                                    <th width={350}><b>T??n file</b></th>
                                    <th><b>Ki???u file</b></th>
                                    <th width={190}><b>Tr???ng th??i</b></th>
                                    <th><b>Ng??y t???i l??n</b></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{content.name}</td>
                                    <td>Video</td>
                                    <td width={190} className="upload-result-status">
                                        <p
                                           className={className}
                                        >{(content.status === 'processing')  ? '??ang x??? l??' : 'T??? ch???i'}</p>
                                    </td>
                                    <td>{content.created_at}</td>
                                    <td>
                                        <button 
                                            className="upload-replace"
                                            onClick={() => this.updateVideo(value, true)}
                                        >Ch???n File kh??c</button>
                                        <button 
                                            onClick={() => {this.setState({rejectReason: !this.state.rejectReason})}}
                                            className="upload-fail-reason"
                                        >
                                            {this.state.rejectReason === true ? (
                                                <i className="fa fa-angle-up"></i>
                                            ) : (
                                                <i className="fa fa-angle-down"></i>
                                            )}
                                        </button>
                                    </td>
                                </tr>
                                {this.state.rejectReason === true &&
                                    <tr className="reject_reason">
                                        <td colSpan={5}>
                                            <b>Video b???n t???i l??n b??? t??? ch???i t??? ?????ng v?? l?? do sau:</b>
                                            <ul>
                                                <li>{content.reject_reason}</li>
                                            </ul>
                                        </td>
                                    </tr>
                                }
                            </tbody>
                        </table>
                        <p><b>L??u ??</b>: T???t c??? c??c t???p ph???i c?? k??ch th?????c t???i thi???u l?? 720p v?? nh??? h??n 4.0 GB.</p>
                    </div>
                )}
            </div>
        )
    }
}

export default LectureItemContent;