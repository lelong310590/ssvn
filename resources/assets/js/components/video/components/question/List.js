import React, {Component} from 'react';
import RawHtml from 'react-raw-html';
import _ from 'lodash';
import {BASE_URL} from "../../api";

class List extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            question: {
                title: '',
                content: '',
                owner: {
                    thumbnail: '',
                    first_name: '',
                    last_name: ''
                }
            },
        }

        this.closeConfirmation = this.closeConfirmation.bind(this);
        this.toDetail = this.toDetail.bind(this);
    }

    componentWillMount() {
        let {question} = this.props;
        this.setState({
            question,
        })
    }

    componentWillReceiveProps(nextProps) {
        let {question} = nextProps;
        this.setState({question})
    }

    closeConfirmation(value, id) {
        this.props.closeConfirmation(value, id);
    }

    toDetail(value) {
        this.props.toDetail(value);
    }

    render() {
        let {question, isNew} = this.state;
        let thumbnail = question.owner.thumbnail;
        let firstName = !_.isNull(question.owner.first_name) ? question.owner.first_name.substring(0,1) : '';
        let lastName = !_.isNull(question.owner.last_name) ? question.owner.last_name.substring(0,1) : '';
        let name = firstName + lastName;
        return(
            <div className={`question-list-item-wrapper`}>
                <div className={`question-list-item`} onClick={() => this.toDetail(question)}>
                    <div className="question-list-item-avatar">
                        {_.isEmpty(thumbnail) ? (
                            <div className={`question-list-item-avatar-text`}>
                                <div className="question-list-item-avatar-text-detail">
                                    {name}
                                </div>
                            </div>
                        ) : (
                            <img src={BASE_URL + thumbnail} className={`img-responsive question-list-item-avatar`} width={40} height={40} />
                        )}
                    </div>
                    <div className="question-list-item-content">
                        <div className="question-list-item-title">
                            {question.title}
                        </div>
                        <div className="question-list-item-content-detail">
                            <RawHtml.div>{question.content.replace(/<[^>]+>/g, '').substring(0, 100)}</RawHtml.div>
                        </div>
                    </div>
                </div>
                {question.isNew &&
                    <div className={`question-list-item-confirmation`}>
                        <i className="fas fa-check-circle"></i>
                        <h4>Câu hỏi đã được tạo thành công</h4>
                        <p>Chúng tôi sẽ thông báo cho bạn các câu trả lời để bạn có thể đánh dấu chúng là hữu ích hoặc là câu trả lời cho câu hỏi của bạn.</p>
                        <p>Nếu câu hỏi của bạn mang tính tổng quát hơn, bạn có thể thử tìm kiếm trên Google, Quora hoặc StackExchange trong khi chờ người hướng dẫn hoặc các sinh viên khác trợ giúp.</p>
                        <i className="fas fa-times"
                            onClick={() => this.closeConfirmation(false, question.id)}
                        ></i>
                    </div>
                }
            </div>
        )
    }
}

export default List;