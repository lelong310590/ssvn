import React, {Component} from 'react';
import ReactDom from 'react-dom';
import CourseCarousel from './../home/CourseCarousel';
import * as api from "../api";

class CourseContentList extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            mostView: [],
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
            this.setState({
                mostView: [1,2,3,4,5,6,7,8]
            })
        })
        .catch((err) => {
            console.log('Err :' + err.message);
        });
    }

    render() {
        return(
            <div>
                <CourseCarousel title={'Top các Khóa đào tạo được xem nhiều nhất'} items={this.state.mostView}/>
                <CourseCarousel title={'Top Các Khóa đào tạo Trung học phổ thông cơ sở'} items={this.state.mostView}/>
                <CourseCarousel title={'Top Các Khóa đào tạo Trung học cơ sở'} items={this.state.mostView}/>
                <CourseCarousel title={'Top Các Khóa đào tạo tiểu học'} items={this.state.mostView}/>
            </div>
        )
    }
}

export default CourseContentList;

if (document.getElementById('CourseList')) {
    ReactDom.render(<CourseContentList/>, document.getElementById('CourseList'))
}

