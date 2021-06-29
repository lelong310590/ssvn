import React, {Component} from 'react';
import axios from 'axios';
import * as api from './../../api';
import _ from 'lodash';

class QuizRelatedLecure extends Component
{
    constructor(props) {
        super(props);
        this.state = {
            relatedLecture: [],
            value: 0
        }
        this.handleChange = this.handleChange.bind(this);
    }

    componentWillMount() {
        let {selected} = this.props;
        this.setState({value: (_.isNull(selected) ? 0 : selected)})
        axios.get(api.GET_RELATED_LECTURE, {
            params: {
                course_id: this.props.cId
            }
        })
        .then((resp) => {
            if (resp.status === 200) {
                this.setState({
                    relatedLecture: resp.data
                })
            }
        })
        .catch((e) => {
            console.log(e);
        })
    }

    handleChange(event) {
        this.setState({value: event.target.value});
        this.props.selectRelated(event.target.value)
    }

    render() {
        let {relatedLecture} = this.state;
        let elem = relatedLecture.map((v, i) => {
            return (
                <option value={v.id} key={i}>{v.name}</option>
            )
        })

        return (
            <select className="form-control" value={this.state.value} onChange={this.handleChange}>
                <option value={0}>-- Chọn một bài liên quan --</option>
                {elem}
            </select>
        )
    }
}

export default QuizRelatedLecure;