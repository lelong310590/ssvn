import React, {Component} from 'react';
import {Modal, Button} from 'react-bootstrap';
import axios from 'axios';
import * as api from './../../api';
import moment from "moment";

class Module extends Component
{
    static defaultProps = {
        isOpening: false,
    };

    state = {
        records: [],
    };

    updateLeaderboard = (records = []) => {
        this.setState({
            records,
        });
    };

    millisToMinutesAndSeconds = (seconds) => {
        let formatted = moment.utc(seconds*1000).format('mm:ss');
        return formatted;
    }

    componentDidMount(){
        axios.get(api.LEADERBOARD, {
            params: {
                lecture_id: this.props.lectureId,
            }
        })
            .then(response => {
                this.updateLeaderboard(Object.values(response.data));
            });
    }

    handleClose = () => {
        this.props.onClose();
    }

    render(){
        const { isOpening, onClose } = this.props;
        const { records } = this.state;
        return (
            <Modal show={isOpening} onHide={onClose}>
                <Modal.Header>
                    <Modal.Title>Báng xếp hạng</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <table className="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th width="200">Tên</th>
                            <th>Điểm</th>
                            <th width="200">Thời gian làm bài</th>
                            <th width="200">Thời gian nộp bài</th>
                        </tr>
                        </thead>
                        <tbody>
                        { records && !!records.length && records.map((record, index) => (
                            <tr key={index}>
                                <td>{index + 1}</td>
                                <td>{record.owner.email}</td>
                                <td>{record.owner.first_name} {record.owner.last_name}</td>
                                <td>{record.score * record.percent_correct /100}/{record.score}</td>
                                <td className="text-center">{this.millisToMinutesAndSeconds(record.time)}</td>
                                <td>{moment(record.created_at).format('HH:mm D/M/Y')}</td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={this.handleClose}>Đóng lại</Button>
                </Modal.Footer>
            </Modal>
        )
    }
}

export default Module;