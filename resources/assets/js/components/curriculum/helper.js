import _ from 'lodash';
import moment from 'moment';

export const convertDuration = (duration) => {
    let formatted = moment.utc(duration*1000).format('HH:mm:ss');
    return formatted;
}