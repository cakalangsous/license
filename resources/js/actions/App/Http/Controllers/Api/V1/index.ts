import LicenseController from './LicenseController'
import ActivationController from './ActivationController'
import HeartbeatController from './HeartbeatController'
const V1 = {
    LicenseController: Object.assign(LicenseController, LicenseController),
ActivationController: Object.assign(ActivationController, ActivationController),
HeartbeatController: Object.assign(HeartbeatController, HeartbeatController),
}

export default V1