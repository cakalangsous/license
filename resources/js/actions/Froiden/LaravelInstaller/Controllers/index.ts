import WelcomeController from './WelcomeController'
import EnvironmentController from './EnvironmentController'
import RequirementsController from './RequirementsController'
import PermissionsController from './PermissionsController'
const Controllers = {
    WelcomeController: Object.assign(WelcomeController, WelcomeController),
EnvironmentController: Object.assign(EnvironmentController, EnvironmentController),
RequirementsController: Object.assign(RequirementsController, RequirementsController),
PermissionsController: Object.assign(PermissionsController, PermissionsController),
}

export default Controllers