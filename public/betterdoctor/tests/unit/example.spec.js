import { expect } from "chai";
import { shallowMount } from "@vue/test-utils";
import Index from "../../src/pages/Index.vue";

describe("HelloWorld.vue", () => {
  it("renders heading", () => {
    const wrapper = shallowMount(Index);
    expect(wrapper.text()).to.include("Pet Symptom Checker");
  });
});
