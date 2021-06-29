import React, {Component} from 'react';
import * as api from './../../../curriculum/api'

class QuestionListEmpty extends Component
{
    constructor(props) {
        super(props);
    }

    render() {
        return(
            <div className={'question-empty-content text-center'}>
                <div className={'question-empty-text'}>
                    <p className={'question-empty-text-title'}>Chưa có câu hỏi nào</p>
                    <p>Hãy là người đầu tiên đặt câu hỏi của bạn! Bạn sẽ có thể thêm chi tiết trong bước tiếp theo.</p>
                </div>
                <img src={api.BASE_URL + 'frontend/images/raise_your_hand.png'} alt="Dơ tay phát biểu"/>
            </div>
        )
    }
}

export default QuestionListEmpty;