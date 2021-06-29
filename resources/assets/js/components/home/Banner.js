import React, {Component} from 'react';
import ReactDom from 'react-dom';

class Banner extends Component 
{
    render() 
    {
        return(
            <div className="box-banner">
                <div className="container">
                    <div className="main-search">
                        <h3 className="txt-title">Học với những người giỏi nhất</h3>
                        <p className="txt">Xây dựng và củng cố kiến thức từ các giáo viên tâm huyết với giá chỉ từ 299k.</p>
                        <div className="box-search">
                            <div className="form-group">
                                <input type="search" className="txt-form" placeholder="Bạn muốn học hỏi điều gì" />
                                <button type="submit" className="btn btn-search">
                                    <i className="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Banner;

if (document.getElementById('SearchBanner')) {
    ReactDom.render(<Banner/>, document.getElementById('SearchBanner'));
}