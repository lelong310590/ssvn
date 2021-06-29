import React, {Component} from 'react';
import ReactDom from 'react-dom';
import * as api from './../api';
import _ from "lodash";

class TopTeacher extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            teacher: [1, 2]
        }
    }

    componentWillMount() {
        fetch(api.GET_TOP_TEACHER, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                moodlewsrestformat: 'json',
            })
        })
        .then(resp => resp.json())
        .then((respJson) => {

        })
        .catch((err) => {
            console.log('Err :' + err.message);
        });
    }

    render() {

        const teacher = this.state.teacher.map((value, index) => {
            return(
                <div className="main-teacher col-xs-6" key={index}>
                    <a href="#" className="img pull-left img-circle">
                        <img src="../images/img-6.jpg" alt="" width="" height=""/>
                    </a>
                    <div className="detail overflow">
                        <div className="info">
                            <h4 className="txt"><a href="#">Nguyễn Văn Minh</a></h4>
                            <p className="des">Giáo viên toán hang đầu cấp 2, luyên thi Toán cấp 3 cho các
                                cháu</p>
                            <ul className="clearfix list-share">
                                <li className="pull-left global"><a href="#"><img
                                    src="../images/icons/world-map-global-earth-icon.svg"/></a></li>
                                <li className="pull-left google"><a href="#"><i
                                    className="fab fa-google"></i></a></li>
                                <li className="pull-left facebook"><a href="#"><i
                                    className="fab fa-facebook-square"></i></a></li>
                                <li className="pull-left youtube"><a href="#"><i className="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                        <a href="#" className="btn-white">Chi tiết</a>
                    </div>
                </div>
            )
        });

        return(
            <div className="box-teacher-top">
                <div className="container">
                    <div className="box-title">
                        <h3 className="txt-title">Top các giáo viên có Khóa đào tạo bán chạy nhất</h3>
                    </div>
                    <div className="list-teacher row">
                        {teacher}
                    </div>
                </div>
            </div>
        )
    }
}

export default TopTeacher;

if (document.getElementById('TopTeacher')) {
    ReactDom.render(<TopTeacher/>, document.getElementById('TopTeacher'))
}