import InstallerController from './InstallerController'
import Frontend from './Frontend'
import Core from './Core'
import Api from './Api'
const Controllers = {
    InstallerController: Object.assign(InstallerController, InstallerController),
Frontend: Object.assign(Frontend, Frontend),
Core: Object.assign(Core, Core),
Api: Object.assign(Api, Api),
}

export default Controllers