import React, { Component } from 'react'
import {Panel, Tabs, Tab} from 'react-bootstrap';
import SectionList from "./sections/SectionList";
import QuestionList from "./question/QuestionList";

class CourseItemList extends Component {

    constructor(props, context) {
        super(props, context);
        this.state = {
            key: 1,
        };

        this.handleSelect = this.handleSelect.bind(this);
        this.onSearch = this.onSearch.bind(this)
    }

    handleSelect(key) {
        this.setState({ key });
    }

    onSearch({ lecture }) {
        this.props.onSearch({ lecture });
    }

    render() {
        let statusClass = this.props.showList ? 'curriculum-nav-open' : ''
        return (
            <div className={`curriculum-nav ${statusClass}`}>
                <Tabs
                    activeKey={this.state.key}
                    onSelect={this.handleSelect}
                    id="controlled-tab-example"
                >
                    <Tab eventKey={1} title="Nội dung Khóa đào tạo">
                        <SectionList
                            list={this.props.list}
                            currentLecture={this.props.currentLecture}
                            courseid={this.props.courseid}
                            userid={this.props.userid}
                            returnCurrentLecture={this.props.returnCurrentLecture}
                            onSearch={this.onSearch}
                            searchResults={this.props.searchResults}
                        />
                    </Tab>
                    <Tab eventKey={2} title="Câu hỏi">
                        <QuestionList
                            lectureid={this.props.currentLecture}
                            courseid={this.props.courseid}
                            userid={this.props.userid}
                        />
                    </Tab>
                </Tabs>
            </div>
        )
    }
}

export default CourseItemList
