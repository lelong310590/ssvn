import React, {Component} from 'react';

class TestOpenContent extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            isNew: true
        }
        this.handleContentStatus = this.handleContentStatus.bind(this);
        this.handleOpenQuizAdd = this.handleOpenQuizAdd.bind(this);
        this.handleMultiQForm = this.handleMultiQForm.bind(this);
    }

    handleContentStatus(value, status) {
        this.props.handleContentStatus(value, status)
    }

    handleOpenQuizAdd(value, status, isNew) {
        this.props.handleOpenQuizAdd(value, status, this.state.isNew)
    }

    handleMultiQForm(value, status) {
        this.props.handleMultiQForm(value, status)
    }

    render() {
        let {value} = this.props;
        return(
            <div className="lecture-add-more">
                <div className="content-type-close">
                    Chọn kiểu câu hỏi
                    <button
                        onClick={() => this.handleContentStatus(value, false)}
                    ><i className="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div className="add-content-wrapper">
                    <ul className="add-content-wrapper-list text-center">
                        <li className="content-type-selector quiz-selector">
                            <button
                                onClick={() => this.handleOpenQuizAdd(value, true)}
                            >
                                <i className="fa fa-file-text-o content-type-icon"></i>
                                <i className="fa fa-file-text-o content-type-icon-hover"></i>
                                <p className="">Một đáp án</p>
                            </button>
                        </li>

                        {1 === 0 &&
                            <li className="content-type-selector quiz-selector">
                                <button
                                    onClick={() => this.handleMultiQForm(value, true)}
                                >
                                    <i className="fa fa-file-text-o content-type-icon"></i>
                                    <i className="fa fa-file-text-o content-type-icon-hover"></i>
                                    <span className="">Nhiều đáp án</span>
                                </button>
                            </li>
                        }
                    </ul>
                </div>
            </div>
        )
    }
}

export default TestOpenContent;