import forEach from 'lodash/forEach'
import './alt-tag.scss'

const $ = window.jQuery
const MEDIA_IMAGE_TYPE = 'image'

export default function() {
  disallowSelectingImageWithoutAltTag()
  provideUserFeedbackForAltTagField()
}

function disallowSelectingImageWithoutAltTag() {
  if (!wp?.media?.view?.Toolbar?.Select) return

  const SelectToolbarParent = wp.media.view.Toolbar.Select.prototype
  const { initialize, refresh } = SelectToolbarParent

  SelectToolbarParent.initialize = function(...args) {
    initialize.apply(this, args)

    if (this.selection) this.selection.on('change:alt', this.refresh, this)
  }

  SelectToolbarParent.refresh = function(...args) {
    refresh.apply(this, args)

    const state = this.controller.state()

    forEach(this._views, (button) => {
      if (!button.model || button.model.get('disabled') || !button.options) {
        return
      }

      const selection = state.get('selection')

      let disabled = false

      if (selection && selection.models) {
        disabled = selection.models.some(
          (attachment) => attachment.get('type') === MEDIA_IMAGE_TYPE && !attachment.get('alt'),
        )
      }

      button.model.set('disabled', disabled)
    })
  }
}

function provideUserFeedbackForAltTagField() {
  if (!wp?.media?.view?.Attachment?.Details) return

  const msgClass = 'sw-media_validation_msg'

  const AttachmentDetails = wp.media.view.Attachment.Details.prototype
  const { initialize, render } = AttachmentDetails

  AttachmentDetails.initialize = function(...args) {
    initialize.apply(this, args)
    this.listenTo(this.model, 'change:alt', this.swSyncAltTagMessage)
  }

  AttachmentDetails.render = function(...args) {
    render.apply(this, args)
    this.swSyncAltTagMessage()
  }

  AttachmentDetails.swSyncAltTagMessage = function() {
    const altWrapper = this.$el.find('[data-setting="alt"]')
    const input = altWrapper.find('input')

    // alt input is only present for images
    if (input.length) {
      input.prop('required', true)

      const msg = altWrapper.find(`.${msgClass}`)

      if (input.val().trim().length === 0) {
        if (msg.length === 0)
          $('<div>')
            .addClass(msgClass)
            .text('Please add a description of the image for ADA compliance')
            .appendTo(altWrapper)
      } else {
        msg.remove()
      }
    }
  }
}
