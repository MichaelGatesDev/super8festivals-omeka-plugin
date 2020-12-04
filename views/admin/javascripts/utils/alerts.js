export default class Alerts {
    static clear(alertsAreaID) {
        const elem = document.getElementById(alertsAreaID);
        if (!elem) return;
        elem.dispatchEvent(new Event("alerts-reset"));
    }

    static triggerAlert(alertsAreaID, alertLevel, alertHeader, alertMsg, onlyThis, alertTimeout) {
        const elem = document.getElementById(alertsAreaID);
        if (!elem) return;
        elem.dispatchEvent(new CustomEvent(onlyThis ? "alert-set" : "alerts-add", {
            "detail": {
                level: alertLevel,
                header: alertHeader,
                body: alertMsg,
                timeout: alertTimeout,
            },
        }));
    }

    static info(alertsAreaID, alertHeader, alertMsg, onlyThis, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "info", alertHeader, alertMsg, onlyThis, alertTimeout);
    }

    static success(alertsAreaID, alertHeader, alertMsg, onlyThis, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "success", alertHeader, alertMsg, onlyThis, alertTimeout);
    }

    static warning(alertsAreaID, alertHeader, alertMsg, onlyThis, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "warning", alertHeader, alertMsg, onlyThis, alertTimeout);
    }

    static error(alertsAreaID, alertHeader, alertMsg, onlyThis, alertTimeout) {
        Alerts.triggerAlert(alertsAreaID, "danger", alertHeader, alertMsg, onlyThis, alertTimeout);
    }
}
