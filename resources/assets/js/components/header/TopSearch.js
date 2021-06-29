import React, {Component} from 'react';
import ReactDom from 'react-dom';

class TopSearch extends Component 
{
    render() {
        return(
            <div className="box-search pull-left">
                <div className="form-group">
                    <input type="search" className="txt-form" placeholder="Tìm kiếm bài học" />
                    <button type="submit" className="btn btn-search">
                        <i className="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
                <div className="box-dropdown">
                    <div className="form-dropdown">
                        <ul>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                            <li>
                                <i className="fas fa-search pull-left"></i>
                                <p className="overflow">
                                    <span>Bài giảng</span> Khóa đào tạo bồi dưỡng lại kiến thức cho học sinh mất gốc
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        )
    }
}

export default TopSearch;

if (document.getElementById('TopSearch')) {
    ReactDom.render(<TopSearch/>, document.getElementById('TopSearch'));
}