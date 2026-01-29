import HomeController from './HomeController'
import BlogController from './BlogController'
const Frontend = {
    HomeController: Object.assign(HomeController, HomeController),
BlogController: Object.assign(BlogController, BlogController),
}

export default Frontend