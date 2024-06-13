// Default error messages
export const DEFAULT_ERROR = "Something went wrong. Please try again later.";

// Error thrown from the server side
export const ALREADY_CLOCKED_IN = "You have already clocked in for today.";
export const INVALID_MEETING_HOUR = "Meeting mode cannot be initiated as you have already clocked out.Please ensure you are on duty to enter meeting mode";
export const NO_MEETING = "Hello, It seems you are attempting to enter meeting mode. However, there are no meetings scheduled for today. If you believe this is an error or if you need assistance, please feel free to contact your supervisor.";
export const NO_ASSIGNED_MEETING = "It appears there aren't any meetings scheduled for you right now. If you believe this is an error or have any questions, please contact your supervisor.";
export const MEETING_ATTENDED = "You have already logged this meeting for today."
export const BREAK_ALREADY_LOGGED = "It looks like you're already on a break or you have already taken your break for today. If you believe this is an error or have any questions, please contact your supervisor.";

// Custom errors
export const OUT_OF_HOURS_MEETING = "Meeting mode cannot be initiated as you have already clocked out. Please ensure you are on duty to enter meeting mode.";
export const TIME_IN_PAST = "You have already clocked in for today.";
export const NO_MEETING_SCHEDULED = "Hello, It seems you are attempting to enter meeting mode. However, there are no meetings scheduled for today. If you believe this is an error or if you need assistance, please feel free to contact your supervisor.";
export const NO_MEETING_ASSIGNED = "It appears there aren't any meetings scheduled for you right now. If you believe this is an error or have any questions, please contact your supervisor.";
export const MEETING_ALREADY_LOGGED = "You have already logged this meeting for today.";
export const BREAK_USED = "It looks like you're already on a break or you have already taken your break for today. If you believe this is an error or have any questions, please contact your supervisor.";