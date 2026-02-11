panel.plugin("hem/switchtube-preview", {
  blocks: {
    video: {
      template: `
        <k-block-figure
          class="k-block-type-video-figure"
          :caption="content.caption"
          :disabled="disabled"
          :empty-text="$t('field.blocks.video.placeholder') + ' …'"
          :is-empty="!videoSrc"
          empty-icon="video"
          @open="open"
          @update="update"
        >
          <k-frame ratio="16/9">
            <iframe
              v-if="videoSrc.videoPlatform === 'switch'"
              class="vimeo-player"
              :src="videoSrc.src"
              width="1280"
              height="720"
              frameborder="0"
              allow="fullscreen"
            />
            <iframe
              v-else-if="videoSrc.videoPlatform === 'vimeo'"
              class="vimeo-player"
              :src="videoSrc.src"
              width="1280"
              height="720"
              frameborder="0"
              referrerpolicy="strict-origin-when-cross-origin"
              allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
              allowfullscreen
            />
            <iframe
              v-else-if="videoSrc.videoPlatform === 'youtube'"
              width="1280"
              height="720"
              :src="videoSrc.src"
              title="YouTube video player"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen
              />
          </k-frame>
        </k-block-figure>
      `,
      computed: {
        videoSrc() {
          const url = this.content.url ?? "";


          const switchMatch = url.match(
            /tube\.switch\.ch\/videos\/([a-zA-Z0-9]+)/
          )
          const vimeoMatch = url.match(
            /vimeo\.com\/([a-zA-Z0-9]+)/
          )
          const youtubeMatch = url.match(
            /youtu\.be\/([a-zA-Z0-9]+)/
          )
          const youtubeVarianteMatch = url.match(
            /youtube\.com\/([a-zA-Z0-9]+)/
          )

          if (switchMatch) {
            return {
              videoPlatform: "switch",
              src: "https://tube.switch.ch/embed/" + switchMatch[1],
            }
          }
          else if(vimeoMatch) {
            return {
              videoPlatform: "vimeo",
              src: "https://player.vimeo.com/video/" + vimeoMatch[1],
            }
          }
          else if(youtubeMatch) {
            return {
              videoPlatform: "youtube",
              src: "https://www.youtube.com/embed/" + youtubeMatch[1],
            }
          }
          else if(youtubeVarianteMatch) {
            const urlObj = new URL(url);
            const videoId = urlObj.searchParams.get('v');


            return {
              videoPlatform: "youtube",
              src: "https://www.youtube.com/embed/" + videoId,
            }
          }

          console.error('url invalid: ', url)

          return null
        },
      },
    },
  },
});
