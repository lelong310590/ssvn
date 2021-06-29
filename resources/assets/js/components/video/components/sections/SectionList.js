import React, {Component} from 'react'
import CourseSingleSection from './../sections/CourseSingleSection'
import axios from 'axios';
import {SEARCH_LECTURE} from "../../api";

class SectionList extends Component
{
    state = {
        keyword: ''
    };

    onSearch = (e) => {
        this.setState({
            keyword: e.target.value
        });

        axios.post(SEARCH_LECTURE, {
            keyword: e.target.value,
            cId: this.props.courseid
        })
        .then((resp) => {
            if (resp.status === 200) {
                let lecture = resp.data;
                this.props.onSearch({ lecture })
            }
        })
        .catch((err) => {
            console.log(err)
        })
    }

    render() {
        let {list, searchResults} = this.props;

        let singleSectionElem = list.map((value, index) => {
            return (
                <CourseSingleSection
                    key={index}
                    data={value}
                    index={index}
                    currentLecture={this.props.currentLecture}
                    courseid={this.props.courseid}
                    userid={this.props.userid}
                    returnCurrentLecture={this.props.returnCurrentLecture}
                    searchResults={searchResults}
                />
            )
        })

        return (
            <div>
                <div className="curriculum-nav-title">
                    <form className="form curriculum-nav-form">
                        <div className="form-group">
                            <input
                                type="text"
                                className="form-control"
                                placeholder="Tìm kiếm nội dung Khóa đào tạo"
                                value={this.state.keyword}
                                onChange={this.onSearch}
                            />
                        </div>

                        <button type="submit" className="btn btn-primary">
                            <i className="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <div className="curriculum-navigator">
                    {singleSectionElem}
                </div>
            </div>
        )
    }
}

export default SectionList;