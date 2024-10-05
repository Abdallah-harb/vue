import { createRouter, createWebHistory } from 'vue-router'
import AllBlog from "../views/Blog/AllBlog.vue";
import Home from "../views/Home/Home.vue";
import SingleBlog from "../views/Blog/SingleBlog.vue";
import CreateBlog from "../views/Blog/CreateBlog.vue";
import EditBlog from "../views/Blog/EditBlog.vue";
import Register from "../views/Auth/Register.vue";
import Login from "../views/Auth/Login.vue";
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/auth/register',
            name: 'register',
            component:Register,
            meta:{
                "title" : "Register"
            }
        },
        {
            path: '/auth/login',
            name: 'login',
            component:Login,
            meta:{
                "title" : "Login"
            }
        },
        {
            path: '/',
            name: 'home',
            component:Home,
            meta:{
                "title" : "Home",
                "requireAuth" : true
            }
        },
        {
            path: '/blogs',
            name: 'blogs',
            component:AllBlog,
            meta:{
                "title" : "Blogs",
                "requireAuth" : true
            }
        },
        {
            path: '/blog/:slug',
            name: 'show.blog',
            component:SingleBlog,
            meta:{
                "title" : "Blogs",
                "requireAuth" : true
            }
        },
        {
            path:'/blog-create',
            name:'create-blog',
            component:CreateBlog,
            meta:{
                'title':"create-blog",
                "requireAuth" : true
            }
        },
        {
            path:'/blog-edit/:id/:slug',
            name:'edit-blog',
            component:EditBlog,
            meta:{
                'title':"Edit - Blog",
                "requireAuth" : true
            }
        }
    ]
})
router.beforeEach((to,from,next) =>{
    document.title = to.meta.title??"Blog";
    next();
});
export default router
