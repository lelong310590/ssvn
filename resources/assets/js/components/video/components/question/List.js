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
                        <h4>C??u h???i ???? ???????c t???o th??nh c??ng</h4>
                        <p>Ch??ng t??i s??? th??ng b??o cho b???n c??c c??u tr??? l???i ????? b???n c?? th??? ????nh d???u ch??ng l?? h???u ??ch ho???c l?? c??u tr??? l???i cho c??u h???i c???a b???n.</p>
                        <p>N???u c??u h???i c???a b???n mang t??nh t???ng qu??t h??n, b???n c?? th??? th??? t??m ki???m tr??n Google, Quora ho???c StackExchange trong khi ch??? ng?????i h?????ng d???n ho???c c??c sinh vi??n kh??c tr??? gi??p.</p>
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