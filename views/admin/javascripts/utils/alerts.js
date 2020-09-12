export default class Alerts {
    static clear(alertsAreaID) {
        document.getElementById(alertsAreaID).dispatchEvent(new Event("alerts-reset"));
    }

    static triggerAlert(alertsAreaID, alertLevel, alertHeader, alertMsg, alertTimeout) {
        document.getElementById(alertsAreaID).dispatchEvent(new CustomEvent("alerts-add", {
            'detail': {
                level: alertLevel,
                header: alertHeader,
                body: alertMsg,
                timeout: alertTimeout,
            },
        }));
    }

    static info(alertsAreaID, alertHeader, alertMsg, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "info", alertHeader, alertMsg, alertTimeout);
    }

    static success(alertsAreaID, alertHeader, alertMsg, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "success", alertHeader, alertMsg, alertTimeout);
    }

    static warning(alertsAreaID, alertHeader, alertMsg, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "warning", alertHeader, alertMsg, alertTimeout);
    }

    static error(alertsAreaID, alertHeader, alertMsg, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "danger", alertHeader, alertMsg, alertTimeout);
    }
}
