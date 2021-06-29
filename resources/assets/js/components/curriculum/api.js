export const BASE_URL = process.env.MIX_APP_URL;
export const ADD_ITEM = BASE_URL+'services/course/curriculum/add-item';
export const GET_ALL_ITEMS = BASE_URL+'services/course/curriculum/get-all-items';
export const DELETE_ITEM = BASE_URL+'services/course/curriculum/delete-item';
export const UPDATE_ITEM = BASE_URL+'services/course/curriculum/update-item';
export const UPDATE_ON_SORT_END = BASE_URL+'services/course/curriculum/update-on-sort-end';
export const UPDATE_DESCRIPTION = BASE_URL+'services/course/curriculum/update-description';
export const UPDATE_STATUS = BASE_URL+'services/course/curriculum/update-course-status';
export const UPDATE_PREVIEW = BASE_URL+'services/course/curriculum/update-preview-status';
export const GET_RELATED_LECTURE = BASE_URL+'services/course/curriculum/related-curriculum';
export const UPDATE_TEST = BASE_URL+'services/course/curriculum/update-test';
export const GET_LECTURE_INFO = BASE_URL+'services/course/curriculum/get-lecture-info';
export const UPLOAD_IMAGE = BASE_URL+'services/course/curriculum/upload-image';

export const UPLOAD_VIDEO = BASE_URL+'services/media/video/upload';
export const GET_LIST_VIDEO = BASE_URL+'services/media/video/get-list-video'
export const DELETE_VIDEO = BASE_URL+'services/media/video/delete-video';
export const UPDATE_CURRICULUM_VIDEO = BASE_URL+'services/media/video/update-curriculum-video';
export const UPLOAD_RESOURCE = BASE_URL+'services/media/resource/upload-resource';
export const DELETE_RESOURCE = BASE_URL+'services/media/resource/delete-resource';
export const SET_NULL_RESOURCE = BASE_URL+'services/media/resource/set-null-resource';
export const GET_LIST_RESOURCE = BASE_URL+'services/media/resource/get-list-resource';
export const UPDATE_RESOURCE = BASE_URL+'services/media/resource/update-resource'

export const ADD_QUESTION = BASE_URL+'services/multiplechoices/question/add-question';
export const ADD_ANSWERS = BASE_URL+'services/multiplechoices/answer/add-answers';
export const LIST_ANSWERS = BASE_URL+'services/multiplechoices/answer/list-answers';
export const UPDATE_QUESTION_ON_SORT_END = BASE_URL+'services/multiplechoices/question/update-on-sort-end';
export const DELETE_QUESTION = BASE_URL+'services/multiplechoices/question/delete-question';
export const UPDATE_QUESTION = BASE_URL+'services/multiplechoices/question/update-question';
export const CREATE_TEST_QUESTION = BASE_URL+'services/multiplechoices/test/create-test-question';
export const UPDATE_TEST_QUESTION = BASE_URL+'services/multiplechoices/test/update-test-question';

export const GET_LECTURE_CONTENT = BASE_URL+'services/multiplechoices/get-lecture-content';
export const GET_LECTURE_INFO_ROUTE = BASE_URL+'services/course/curriculum/get-lecture-info-route';
export const GET_ALL_QUESTION_AND_ANSWER = BASE_URL+'services/course/curriculum/get-all-question-and-answer'
