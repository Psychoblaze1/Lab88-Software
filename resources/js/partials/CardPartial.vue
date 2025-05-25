<template>
  <div class="col-span-1 w-full overflow-y-auto">
    <div class="bg-white rounded-md shadow">
      <div class="flex flex-row justify-between p-4 border-b border-gray-500">
        <div>
          <slot name="icon"></slot>
          <h1 class="text-2xl font-semibold leading-none">
            <slot name="title"></slot>
          </h1>
        </div>
        <div class="justify-end flex">
          <slot name="cta"></slot>
        </div>
      </div>
      <div class="p-4 overflow-y-auto w-full">
        <slot name="content"></slot>
      </div>
    </div>

    <div class="mt-4">
      <slot name="action-button"></slot>
    </div>
  </div>
</template>
