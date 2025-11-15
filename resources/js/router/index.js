import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';
import Home from '../Landing/Home.vue';
import About from '../Landing/About.vue';
import Contact from '../Landing/Contact.vue';
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import Dashboard from '../components/Dashboard.vue';
import Profile from '../components/Profile.vue';
import ProjectList from '../components/Projects/ProjectList.vue';
import ProjectForm from '../components/Projects/ProjectForm.vue';
import ProjectDetail from '../components/Projects/ProjectDetail.vue';
import TaskList from '../components/Tasks/TaskList.vue';
import TaskForm from '../components/Tasks/TaskForm.vue';
import TaskDetail from '../components/Tasks/TaskDetail.vue';
import BoardList from '../components/Boards/BoardList.vue';
import BoardForm from '../components/Boards/BoardForm.vue';
import BoardDetail from '../components/Boards/BoardDetail.vue';
import ReportList from '../components/Reports/ReportList.vue';
import ReportForm from '../components/Reports/ReportForm.vue';
import ReportDetail from '../components/Reports/ReportDetail.vue';

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Dashboard' }
    },
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Profile' }
    },
  },
  {
    path: '/projects',
    name: 'ProjectList',
    component: ProjectList,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Projects' }
    },
  },
  {
    path: '/projects/create',
    name: 'ProjectCreate',
    component: ProjectForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Projects', path: '/projects' },
        { label: 'Create Project' }
      ]
    },
  },
  {
    path: '/projects/:id',
    name: 'ProjectDetail',
    component: ProjectDetail,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Projects', path: '/projects' },
        { label: 'Project :id' }
      ]
    },
  },
  {
    path: '/projects/:id/edit',
    name: 'ProjectEdit',
    component: ProjectForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Projects', path: '/projects' },
        { label: 'Project :id', path: '/projects/:id' },
        { label: 'Edit' }
      ]
    },
  },
  {
    path: '/tasks',
    name: 'TaskList',
    component: TaskList,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Tasks' }
    },
  },
  {
    path: '/tasks/create',
    name: 'TaskCreate',
    component: TaskForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Tasks', path: '/tasks' },
        { label: 'Create Task' }
      ]
    },
  },
  {
    path: '/projects/:projectId/tasks/create',
    name: 'TaskCreateForProject',
    component: TaskForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Projects', path: '/projects' },
        { label: 'Project :projectId', path: '/projects/:projectId' },
        { label: 'Create Task' }
      ]
    },
  },
  {
    path: '/tasks/:id',
    name: 'TaskDetail',
    component: TaskDetail,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Tasks', path: '/tasks' },
        { label: 'Task :id' }
      ]
    },
  },
  {
    path: '/tasks/:id/edit',
    name: 'TaskEdit',
    component: TaskForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Tasks', path: '/tasks' },
        { label: 'Task :id', path: '/tasks/:id' },
        { label: 'Edit' }
      ]
    },
  },
  {
    path: '/boards',
    name: 'BoardList',
    component: BoardList,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Boards' }
    },
  },
  {
    path: '/boards/create',
    name: 'BoardCreate',
    component: BoardForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Boards', path: '/boards' },
        { label: 'Create Board' }
      ]
    },
  },
  {
    path: '/projects/:projectId/boards/create',
    name: 'BoardCreateForProject',
    component: BoardForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Projects', path: '/projects' },
        { label: 'Project :projectId', path: '/projects/:projectId' },
        { label: 'Create Board' }
      ]
    },
  },
  {
    path: '/boards/:id',
    name: 'BoardDetail',
    component: BoardDetail,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Boards', path: '/boards' },
        { label: 'Board :id' }
      ]
    },
  },
  {
    path: '/boards/:id/edit',
    name: 'BoardEdit',
    component: BoardForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Boards', path: '/boards' },
        { label: 'Board :id', path: '/boards/:id' },
        { label: 'Edit' }
      ]
    },
  },
  {
    path: '/reports',
    name: 'ReportList',
    component: ReportList,
    meta: {
      requiresAuth: true,
      breadcrumb: { label: 'Reports' }
    },
  },
  {
    path: '/reports/create',
    name: 'ReportCreate',
    component: ReportForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Reports', path: '/reports' },
        { label: 'Create Report' }
      ]
    },
  },
  {
    path: '/reports/:id',
    name: 'ReportDetail',
    component: ReportDetail,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Reports', path: '/reports' },
        { label: 'Report :id' }
      ]
    },
  },
  {
    path: '/reports/:id/edit',
    name: 'ReportEdit',
    component: ReportForm,
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { label: 'Reports', path: '/reports' },
        { label: 'Report :id', path: '/reports/:id' },
        { label: 'Edit' }
      ]
    },
  },
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/about',
    name: 'About',
    component: About,
  },
  {
    path: '/contact',
    name: 'Contact',
    component: Contact,
  },
  {
    path: '/features',
    name: 'Features',
    component: Home, // Temporary - can create separate component later
  },
  {
    path: '/pricing',
    name: 'Pricing',
    component: Home, // Temporary - can create separate component later
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// Navigation guard for authentication
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !token) {
    next('/login');
  } else if ((to.path === '/login' || to.path === '/register') && token) {
    next('/dashboard');
  } else {
    next();
  }
});

export default router;
