import React, { Component } from 'react'
import axios from 'axios';
import * as api from './../api';
import _ from 'lodash';
import moment from 'moment'

class ResourceLibrary extends Component 
{
    constructor(props) {
        super(props)
        this.state = {
            media: []
        }
        this.showRejectReason = this.showRejectReason.bind(this);
        this.deleteMedia = this.deleteMedia.bind(this);
        this.changeMedia = this.changeMedia.bind(this)
    }
    
    componentWillMount() {
        let {userid} = this.props;
        axios.get(api.GET_LIST_RESOURCE, {
            params: {
                owner: userid
            }
        })
        .then((resp) => {
            console.log(resp);
            if (resp.status === 200) {
                this.setState({
                    media: resp.data
                })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    showRejectReason(index) {
        let {media} = this.state;
        let showReason = media[index].show_reason;
        media[index].show_reason = !showReason;
        this.setState({media})
    }

    deleteMedia(id) {
        axios.post(api.DELETE_RESOURCE, {id})
        .then((resp) => {
            //console.log(resp)
            if (resp.status === 200) {
                let {media} = this.state;
                let index = _.findIndex(media, ['id', id]);
                _.pullAt(media, index);
                this.setState({media})
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    changeMedia(value) {
        let {userid} = this.props;
        axios.post(api.UPDATE_RESOURCE, {
            id: value.id,
            curItem: this.props.curriculum,
            owner: userid
        })
        .then((resp) => {
            if (resp.status === 200) {
                this.setState({media: resp.data.media})
                this.props.onChangeResource(resp.data.curriculum, value)
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    render() {
        const media = this.state.media.map((value, index) => {
            let statusName = 'Từ chối';
            let statusClass = 'fail'

            if (value.status === 'active') {
                statusName = 'Thành công',
                statusClass = 'success'
            }

            return (
                <tbody key={index}>
                    <tr>
                        <td>{value.name}</td>
                        <td>File</td>
                        <td width={190} className="upload-result-status">
                            <p className={statusClass}>{statusName}</p>
                        </td>
                        <td>{moment(value.created_at).format('DD/MM/YYYY')}</td>
                        <td className="media-lib-toolbar">
                            {value.status === 'active' && 
                                <button 
                                    className="upload-replace"
                                    onClick={() => this.changeMedia(value)}
                                >Chọn File</button>
                            }

                            <button 
                                className="upload-replace"
                                onClick={() => this.deleteMedia(value.id)}
                            ><i className="fa fa-trash-o"></i></button>

                            {value.status === 'disable' &&
                                <button 
                                    onClick={() => this.showRejectReason(index)}
                                    className="upload-fail-reason"
                                >
                                    {value.show_reason === true ? (
                                        <i className="fa fa-angle-up"></i>
                                    ) : (
                                        <i className="fa fa-angle-down"></i>
                                    )}
                                </button>
                            }
                        </td>
                    </tr>
                    {value.show_reason === true &&
                        <tr className="reject_reason">
                            <td colSpan={5}>
                                <b>Video bạn tải lên bị từ chối tự động vì lý do sau:</b>
                                <ul>
                                    <li>{value.reject_reason}</li>
                                </ul>
                            </td>
                        </tr>
                    }
                </tbody>
            )
        })

        return(
            <div className="table-responsive uploaded-table-result">
                <table className="table">
                    <thead>
                        <tr>
                            <th width={350}>
                                <b>Tên file</b>
                                <button><i className="fa fa-sort-down"></i></button>
                            </th>
                            <th>
                                <b>Kiểu file</b>
                            </th>
                            <th width={190}>
                                <b>Trạng thái</b>
                                <button><i className="fa fa-sort-down"></i></button>
                            </th>
                            <th><b>Ngày tải lên</b></th>
                            <th></th>
                        </tr>
                    </thead>
                    {media}
                </table>
            </div>
        )
    }
}

export default ResourceLibrary
