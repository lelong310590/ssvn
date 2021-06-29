import React, { Component } from 'react'
import {withRouter} from 'react-router-dom';
import * as api from './../api';

class FirstStep extends Component {

    constructor(props) {
        super(props);
    }

    nextPath(path) {
        this.props.history.push(path);
        this.props.nextStep(2);
    }

    render() {
        return (
            <div>

                
                <div className="body">
                    <div className="container">
                        <h1 className="title text-center">Đầu tiên, chúng ta hãy tìm ra loại Khóa đào tạo bạn đang làm.</h1>
                        <div className="create-course-wrapper">
                            <div className="create-course-item text-center active">
                                <i className="far fa-file-video"></i>
                                <h2 className="course-type-title">Khóa đào tạo</h2>
                                <div className="course-type-desc">
                                    Tạo trải nghiệm học tập phong phú với sự trợ giúp của các bài giảng video, câu đố, bài tập mã hóa, v.v.
                                </div>
                            </div>
                            
                            <div className="create-course-item text-center">
                                <i className="far fa-check-circle"></i>
                                <h2 className="course-type-title">Bài tập</h2>
                                <div className="course-type-desc">
                                    Giúp sinh viên chuẩn bị cho kỳ thi chứng nhận bằng cách cung cấp câu hỏi thực hành.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div className="footer">
                    <div className="container">
                        <div className="footer-wrapper">
                            <button 
                                onClick={() => this.nextPath(api.BASE_URL + '/buoc2')}
                                type="submit" 
                                className="footer-button pull-right"
                            >Tiếp tục</button>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default withRouter(FirstStep)
