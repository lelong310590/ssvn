import React, {Component} from 'react';
import {Tabs, Tab} from 'react-bootstrap';
import * as api from './../api';
import axios from 'axios';
import MediaLibrary from './MediaLibrary';
import moment from 'moment';

class VideoUploadTabs extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            key: 1,
            fileData: '',
            percent: 0,
            onupload: false,
            uploadFinish: false,
            token: '',
            timeUpload: '',
            fileName: ''
        };
        this.handleSelect = this.handleSelect.bind(this);
        this.handleFileUpload = this.handleFileUpload.bind(this);
        this.cancelRequest = this.cancelRequest.bind(this);
        this.uploadLecureContent = this.uploadLecureContent.bind(this);
        this.onChangeMedia = this.onChangeMedia.bind(this)
    }

    handleSelect(key) {
        this.setState({ key });
    }

    uploadLecureContent() {
        let {fileData} = this.state;
        let {value} = this.props;
        this.props.uploadLecureContent(fileData, value);
    }

    cancelRequest() {
        this.state.token.cancel();
        this.setState({
            percent: 0,
            onupload: false,
            uploadFinish: false,
            token: ''
        })
    }

    onChangeMedia(value, media) {
        this.props.onChangeMedia(value, media)
    }

    handleFileUpload(data)
    {
        let  d = new Date(_.now());
        
        const file = data[0];
        let formData = new FormData()
        
        let size = file.size;
        let userid = this.props.userid;
        let curriculum = this.props.value.id;

        formData.append('file', file)
        formData.append('userid', userid)
        formData.append('curriculum', curriculum)

        this.setState({
            timeUpload: moment().format('DD/MM/YYYY'),
            fileName: file.name
        })

        const CancelToken = axios.CancelToken;
        const source = CancelToken.source();
        this.setState({token: source})
        const config = {
            headers: {'Content-Type': 'multipart/form-data'},
            onUploadProgress: progressEvent => {
                let percent = Math.round(progressEvent.loaded / progressEvent.total * 100);
                this.setState({
                    percent,
                    onupload: true,
                });
            },
            cancelToken: source.token
        }

        axios.post(api.UPLOAD_VIDEO, formData, config)
            .then((response) => {
                console.log(response);
                if (response.status === 200) {
                    this.setState({
                        uploadFinish: true,
                        fileData: response.data.video
                    });
                    this.uploadLecureContent();
                    this.props.changeCurriculumStatus(response.data.curriculum)
                }
            })
            .catch((error) => {
                if (axios.isCancel(error)) {
                    // console.log('Request canceled', error.message);
                } else {
                    console.log(error);
                }
            })

        // if (size > (1024*1024*1024*4)) {
        //     alert('T???p tin t???i l??n v?????t qu?? dung l?????ng cho ph??p (4GB)')
        // } else {
        //
        // }
    }

    render()
    {
        return(
            <Tabs 
                activeKey={this.state.key}
                onSelect={this.handleSelect}
                id="controlled-tab-example"
            >
                <Tab eventKey={1} title="T???i Video">
                    <div className="video-uploader">
                        {this.state.onupload === false ? (
                            <div>
                                <label className="custom-file">
                                    <input 
                                        placeholder="Ch??a c?? file n??o ???????c ch???n" 
                                        className="custom-file-input" 
                                        name="thumbnail" 
                                        type="file"
                                        accept=".avi,.mpg,.mpeg,.flv,.mov,.m2v,.m4v,.mp4,.rm,.ram,.vob,.ogv,.webm,.wmv"
                                        onChange={(e) => this.handleFileUpload(e.target.files)}
                                    />
                                    <span className="custom-file-control"></span>
                                </label>
                                {/*<p><b>L??u ??</b>: T???t c??? c??c t???p ph???i c?? k??ch th?????c t???i thi???u l?? 720p v?? nh??? h??n 4.0 GB.</p>*/}
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
                                            <td>{this.state.fileName}</td>
                                            <td>Video</td>
                                            <td width={190}>
                                                {this.state.percent < 100 ? (
                                                    <div className="process-bar-wrapper">
                                                        <div className="process-bar-running text-center" style={{width: this.state.percent + '%'}}>
                                                            <span>{this.state.percent} %</span>
                                                        </div>
                                                    </div>
                                                ) : (
                                                    <span>??ang x??? l??</span>
                                                )}
                                            </td>
                                            <td>{this.state.timeUpload}</td>
                                            <td>
                                                <button
                                                    onClick={() => this.cancelRequest()}
                                                ><i className="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </div>
                </Tab>
                <Tab eventKey={2} title="Ch???n t??? th?? vi??n">
                    <MediaLibrary 
                        userid={this.props.userid}
                        curriculum={this.props.value}
                        onChangeMedia={this.onChangeMedia}
                    />
                </Tab>
            </Tabs>
        )
    }
}

export default VideoUploadTabs;
