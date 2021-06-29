export const BASE_URL = process.env.MIX_APP_URL;
export const VIDEO_URL = process.env.MIX_VIDEO_URL;

export const GET_LIST_SECTION = BASE_URL+'services/course/curriculum/get-section-item';
export const SEARCH_LECTURE = BASE_URL+'services/course/curriculum/search-curriculum';
export const GET_LECTURE_IN_SECTION = BASE_URL+'services/course/curriculum/get-lecture-in-section';
export const GET_VIDEO = BASE_URL+'services/course/curriculum/get-video';
export const GET_SLUG = BASE_URL+'services/course/curriculum/get-slug-via-lectureid';
export const GET_AUTOPLAY = BASE_URL + 'services/users/get-autoplay';
export const SET_AUTOPLAY = BASE_URL + 'services/users/set-autoplay';
export const SUBMIT_LECTURE = BASE_URL + 'services/course/test/submit-lecture';
export const CHECK_ANSWER = BASE_URL + 'services/course/test/check-answer';
export const CHECK_HAVE_RESULT = BASE_URL + 'services/course/test/check-have-test';
export const GET_RESULT = BASE_URL + 'services/course/test/get-result';
export const RESULT_DETAIL = BASE_URL + 'services/course/test/result-detail';
export const CHANGE_PROCESS = BASE_URL + 'services/course/process/change-process';
export const QUESTION_LENGTH = BASE_URL + 'services/multiplechoices/question/question-length';
export const LEADERBOARD = BASE_URL + 'services/course/test/leaderboard';

//QA
export const LIST_QUESTION = BASE_URL + 'services/qa/question/list-question';
export const POST_QUESTION = BASE_URL + 'services/qa/question/post-question';
export const EDIT_QUESTION = BASE_URL + 'services/qa/question/edit-question';
export const DELETE_QUESTION = BASE_URL + 'services/qa/question/delete-question';
export const POST_ANSWER = BASE_URL + 'services/qa/answer/post-answer';
export const LIST_ANSWER = BASE_URL + 'services/qa/answer/list-answer';
export const EDIT_ANSWER = BASE_URL + 'services/qa/answer/edit-answer';

//Process
export const LAST_PROCESSS = BASE_URL + 'services/course/process/update-last-process';

//Rating
export const CHECK_IS_RATED = BASE_URL + 'services/rating/check-is-rated';
export const POST_RATING = BASE_URL + 'services/rating/post-rating';
