function EventBus() {
    const subscriptions = {};

    /**
     * @param eventType {S8FEvent} The event to subscribe to
     * @param callback {function} The function to trigger when the event fires
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
     * @param eventType {S8FEvent} The event to dispatch
     * @param callback {Object} The arguments to pass to the callback function
     */
    function dispatch(eventType, args) {
        if (!subscriptions[eventType]) return;
        subscriptions[eventType].forEach((callback) => callback(args));
    }

    return { subscribe, dispatch };
}

export const eventBus = EventBus();
