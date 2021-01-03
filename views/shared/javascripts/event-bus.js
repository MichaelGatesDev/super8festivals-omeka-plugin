export const S8FEvent = {
    RequestFormSubmit: "request-form-submit",
    CompleteFormSubmit: "complete-form-submit",

    RecordRequestAdd: "record-request-add",
    RecordRequestEdit: "record-request-edit",
    RecordRequestDelete: "record-request-delete",
    RecordRequestView: "record-request-view",
};

function EventBus() {
    const subscriptions = {};

    /**
     * @param eventType {S8FEvent | string} The event to subscribe to
     * @param callback {Function} The function to trigger when the event fires
     */
    function subscribe(eventType, callback) {
        if (!subscriptions[eventType]) {
            subscriptions[eventType] = [];
        }

        subscriptions[eventType].push(callback);

        return {
            unsubscribe: () => {
                subscriptions[eventType] = subscriptions[eventType].filter((c) => c !== callback);
                if (subscriptions[eventType].length === 0) {
                    delete subscriptions[eventType];
                }
            },
        };
    }

    /**
     * @param eventType {S8FEvent | string} The event to dispatch
     * @param args {Object | null} The arguments to pass to the callback function
     */
    function dispatch(eventType, args = null) {
        if (!subscriptions[eventType]) return;
        subscriptions[eventType].forEach((callback) => callback(args));
    }

    return { subscribe, dispatch };
}

export const eventBus = EventBus();
