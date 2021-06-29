import React, {Component} from 'react';
import ReactDom from 'react-dom';
import * as api from './../api';
import _ from "lodash";

class Level extends Component
{

    render() {

        return(
            <div className="box-student-level">
                <div className="container">
                    <div className="box-title">
                        <h3 className="txt-title">Theo trình độ học sinh</h3>
                    </div>
                    <div className="row">
                        <div className="col-xs-4">
                            <div className="row">
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_03.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Cho học sinh mất gốc</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_13.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Ôn học sinh cấp 3</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-xs-4">
                            <div className="row">
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_06.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Ôn thi học sinh giỏi</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_11.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Ôn thi đại học</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-xs-4">
                            <div className="row">
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_08.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Khóa đào tạo nâng cao</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xs-12">
                                    <div className="list-student-level">
                                        <a href="#" className="student-level">
                                            <img src="../images/img-14_16.jpg" alt="" width="" height=""/>
                                                <span className="txt-title">Luyện thi violymic</span>
                                                <div className="search">
                                                    <i className="fas fa-search"></i>
                                                </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Level;

if (document.getElementById('Level')) {
    ReactDom.render(<Level/>, document.getElementById('Level'))
}