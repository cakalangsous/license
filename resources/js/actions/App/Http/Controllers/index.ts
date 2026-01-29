import InstallerController from './InstallerController'
import Frontend from './Frontend'
import Core from './Core'
const Controllers = {
    InstallerController: Object.assign(InstallerController, InstallerController),
Frontend: Object.assign(Frontend, Frontend),
Core: Object.assign(Core, Core),
}

export default Controllers