import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    name: "main",
    //base: process.env.BASE_URL,
    component: () => import(/* webpackChunkName: "layout" */"../pages/Dialer.vue"),
    meta: {
      title: "Callzy"
    }
  },
  {
    path: "/agent/:id",
    name: "agent",
    props: true,
    component: () => import(/* webpackChunkName: "layout" */"../pages/Dialer.vue")
  }
];

const router = new VueRouter({
  mode: "hash", // use instead of hash to remove the hash from the url
  base: process.env.BASE_URL,
  routes
});

router.beforeEach((to, from, next) => {
  const nearestWithTitle = to.matched
    .slice()
    .reverse()
    .find(r => r.meta && r.meta.title);
  if (nearestWithTitle) {
    document.title = nearestWithTitle.meta.title;
  }
  window.popStateDetected = false

  next();
});

export default router;
