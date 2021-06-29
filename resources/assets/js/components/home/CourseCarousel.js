import React, {Component} from 'react';
import ReactDom from 'react-dom';
import OwlCarousel from 'react-owl-carousel';

class CourseCarousel extends Component
{
    constructor(props) {
        super(props);
    }

    render() 
    {
        let carouselItem = this.props.items.map((value, index) => {
            return (
                <div className="item" key={index}>
                    <div className="main-course">
                        <div className="course">
                            <div className="img">
                                <a href="#"><img src="../images/img-1.jpg" alt="" width="" height=""/></a>
                            </div>
                            <div className="content">
                                <h4 className="txt"><a href="#">Khóa H2 - Luyện thi THPT quốc gia môn văn 2018 </a> </h4>
                                <div className="box-star">
                                    <div className="pull-left">
                                        <ul className="clearfix">
                                            <li className="pull-left"><i className="fas fa-star"></i></li>
                                            <li className="pull-left"><i className="fas fa-star"></i></li>
                                            <li className="pull-left"><i className="fas fa-star"></i></li>
                                            <li className="pull-left"><i className="fas fa-star"></i></li>
                                            <li className="pull-left"><i className="fas fa-star-half"></i></li>
                                        </ul>
                                    </div>
                                    <div className="overflow">
                                        <p>4.5 <span>(243)</span></p>
                                    </div>
                                </div>
                                <div className="clearfix">
                                    <div className="pull-left">
                                        <p className="price old">500,000đ</p>
                                    </div>
                                    <div className="pull-right">
                                        <p className="price text-right">
                                            <span>350,000 </span>VNĐ
                                        </p>
                                    </div>
                                </div>
                                <div className="bottom-course row">
                                    <div className="col-xs-6">
                                        <a href="javascript:void(0)" className="view-fast" >Xem nhanh</a>
                                    </div>
                                    <div className="col-xs-6">
                                        <a href="#" className="view-detail">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            )
        });

        return(
            <div className="box-slide box-course box-most-viewed">
                <div className="container">
                    <div className="box-title">
                        <h3 className="txt-title">{this.props.title}</h3>
                    </div>

                    <OwlCarousel 
                        className="list-course owl-carousel"
                        nav={true}
                        autoplay={true} 
                        responsive={
                            {
                                320: {items: 1},
                                480: {items: 2},
                                768: {items: 3},
                                1024: {items: 4},
                                1200: {items: 5},
                            }
                        }
                        loop={true}
                    >

                        {carouselItem}

                    </OwlCarousel>
                </div>
            </div>
        )
    }
}

export default CourseCarousel;
